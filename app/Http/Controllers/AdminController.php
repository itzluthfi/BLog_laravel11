<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBlogs = Blog::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();
        $latestBlogs = Blog::with('author')->latest()->take(5)->get();
        // Ambil jumlah artikel per kategori
        $articlesByCategory = Blog::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->get();
    
        // Ambil nama kategori dan jumlahnya
        $categoryNames = [];
        $articleCounts = [];
    
        foreach ($articlesByCategory as $category) {
            $categoryName = Category::find($category->category_id)->name ?? 'Tanpa Kategori';
            $categoryNames[] = $categoryName;
            $articleCounts[] = $category->total;
        }
    
        return view('admin.dashboard', compact('totalUsers', 'totalBlogs', 'latestBlogs', 'categoryNames', 'articleCounts','totalComments','totalCategories'));
    }
    

  
    // BLOG
    public function blogs(Request $request)

    {
        $query = Blog::with('author')->with('category');
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                  ->orWhere('slug', 'like', "%$search%")
                  ->orWhereHas('author', function ($authorQuery) use ($search) {
                      $authorQuery->where('username', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                  });
                  
        }

    // Filter berdasarkan author_id jika ada
    if ($request->has('author_id') && $request->author_id != '') {
        $query->where('author_id', $request->author_id);
    }
    
        $blogs = $query->paginate(10);
        
        return view('admin.blogs.list', compact('blogs',));
    }
    
    public function createBlog()
    {
        $authors = User::with('role')->get();
        $categories = Category::all();

        return view('admin.blogs.add', compact('authors','categories'));
    }

    public function storeBlog(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'full_content' => 'required|string',
            ]);
    
            if ($request->hasFile('landscape_image')) {
                $landscapeImage = $request->file('landscape_image');
                $landscapeFilename = 'landscape_' . time() . '-' . $landscapeImage->getClientOriginalName();
                $landscapeImage->move(public_path('storage/blog_images'), $landscapeFilename);
                $validated['landscape_image'] = 'storage/blog_images/' . $landscapeFilename; 
            }
    
            if ($request->hasFile('portrait_image')) {
                $portraitImage = $request->file('portrait_image');
                $portraitFilename = 'portrait_' . time() . '-' . $portraitImage->getClientOriginalName();
                $portraitImage->move(public_path('storage/blog_images'), $portraitFilename);
                $validated['portrait_image'] = 'storage/blog_images/' . $portraitFilename;
            }
    
            $validated['author_id'] = Auth::id();
            $validated['published_at'] = now(); 
    
            Blog::create($validated);
    
            return redirect()->route('admin.blogs.list')->with('success', 'Blog berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function editBlog($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail(); 
        $categories = Category::all();
        $user = Auth::user();
        
        return view('admin.blogs.edit', compact('blog', 'categories', 'user'));
    }
    


    public function updateBlog(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);
    
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'full_content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'published_at' => 'nullable|date',
            ]);
    
            if (!$request->filled('published_at')) {
                unset($validated['published_at']);
            }
    
            foreach (['landscape_image', 'portrait_image'] as $imageField) {
                if ($request->hasFile($imageField)) {
                    if ($blog->$imageField) {
                        $this->deleteImage($blog->$imageField);
                    }
                    $validated[$imageField] = $request->file($imageField)->store('uploads/blog_images', 'public');
                } else {
                    unset($validated[$imageField]);
                }
            }
    
            $this->deleteUnusedContentImages($blog->full_content, $validated['full_content']);
    
            $blog->update($validated);
    
            return redirect()->route('admin.blogs.list')->with('success', 'Blog berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

      // 🔴 Fungsi untuk menghapus gambar dari storage
      private function deleteImage($imageUrl)
      {
          if ($imageUrl) {
              $path = str_replace('storage/', '', $imageUrl);
              $filePath = public_path('storage/' . $path);
  
              if (file_exists($filePath)) {
                  unlink($filePath);
              }
          }
      }
  
      // 🔴 Fungsi untuk menghapus gambar dalam full_content
      private function deleteContentImages($fullContent)
      {
          preg_match_all('/<img[^>]+src="([^"]+)"/', $fullContent, $matches);
  
          foreach ($matches[1] as $imageUrl) {
              $this->deleteImage($imageUrl);
          }
      }
  
      // 🔴 Fungsi untuk menghapus gambar lama yang tidak digunakan di full_content baru
      private function deleteUnusedContentImages($oldContent, $newContent)
      {
          preg_match_all('/<img[^>]+src="([^"]+)"/', $oldContent, $oldImages);
          preg_match_all('/<img[^>]+src="([^"]+)"/', $newContent, $newImages);
  
          $oldImages = $oldImages[1] ?? [];
          $newImages = $newImages[1] ?? [];
  
          // Hapus hanya gambar lama yang tidak ada di full_content baru
          foreach ($oldImages as $oldImage) {
              if (!in_array($oldImage, $newImages)) {
                  $this->deleteImage($oldImage);
              }
          }
      }
    


      public function deleteBlog($slug)
      {
          try {
              $blog = Blog::where('slug', $slug)->firstOrFail();
      
              if ($blog->image) {
                  Storage::disk('public')->delete($blog->image);
              }
              if ($blog->portrait_image) {
                  Storage::disk('public')->delete($blog->portrait_image);
              }
      
              $this->deleteContentImages($blog->full_content);
              $blog->delete();
      
              return redirect()->route('admin.blogs.list')->with('success', 'Blog berhasil dihapus!');
          } catch (\Exception $e) {
              return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
          }
      }
      

    public function createUser()
{
    $user = Auth::user();
    return view('admin.users.add',compact('user'));
}



    //USERS
    public function users(Request $request)
    {
        $query = User::with('role');
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }
    
        $users = $query->paginate(10);
    
        return view('admin.users.list', compact('users'));
    }



    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role_id' => 'required|exists:roles,id',
            ]);
    
            $validated['password'] = Hash::make($validated['password']);
    
            User::create($validated);
    
            return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    


    /**
     * Menampilkan form edit user
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user
     */
    public function updateUser(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


    /**
     * Menghapus user
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
    
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    


    public function setting()
    {
        $user = Auth::user(); // Pastikan auth middleware aktif
        return view('admin.setting', compact('user'));
    }
    
    public function updateSetting(Request $request)
{
    try {
        $admin = Auth::user();

        if (!$admin) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $admin = User::find($admin->id);
        
        if ($admin) {
            $admin->update($validated);
            return redirect()->route('admin.setting')->with('success', 'Pengaturan berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui pengaturan.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    
}