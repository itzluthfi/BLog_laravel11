<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBlogs = Blog::count();
        $latestBlogs = Blog::with('author')->latest()->take(5)->get(); // Perbaikan typo
        $categoryNames = ['Teknologi', 'Bisnis', 'Kesehatan', 'Olahraga', 'Hiburan'];
        $articleCounts = [10, 15, 8, 12, 20];
    
        return view('admin.dashboard', compact('totalUsers', 'totalBlogs', 'latestBlogs', 'categoryNames', 'articleCounts'));
    }

    /**
     * Menampilkan daftar user
     */
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
    public function blogs(Request $request)

    {
        $query = Blog::with('author');
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                //   ->orWhere('description', 'like', "%$search%")
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
        $authors = User::with('role')->get();

    
        return view('admin.blogs.list', compact('blogs','authors'));
    }
    
    public function createBlog()
    {
        $authors = User::with('role')->get();
        return view('admin.blogs.add', compact('authors'));
    }

    public function storeBlog(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'full_content' => 'required|string',
            // 'author_id' => 'required|exists:users,id',
            // 'published_at' => 'required|date',
        ]);

        // Simpan file jika ada
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
    }

    public function editBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function updateBlog(Request $request, $id)
    {
    $blog = Blog::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string',
        'full_content' => 'required|string',
        'published_at' => 'nullable|date',
    ]);

    // Jika published_at tidak diisi, hapus dari $validated agar nilai lama tidak tertimpa null.
    if (!$request->filled('published_at')) {
        unset($validated['published_at']);
    }

    if ($request->hasFile('landscape_image')) {
        if ($blog->landscape_image) {
            Storage::disk('public')->delete($blog->landscape_image);
        }
        $validated['landscape_image'] = $request->file('landscape_image')->store('blog_images', 'public');
    }

    if ($request->hasFile('portrait_image')) {
        if ($blog->portrait_image) {
            Storage::disk('public')->delete($blog->portrait_image);
        }
        $validated['portrait_image'] = $request->file('portrait_image')->store('blog_images', 'public');
    }

    $blog->update($validated);

    return redirect()->route('admin.blogs.list')->with('success', 'Blog berhasil diperbarui!');
}


    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        if ($blog->portrait_image) {
            Storage::disk('public')->delete($blog->portrait_image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.list')->with('success', 'Blog berhasil dihapus!');
    }

    public function createUser()
{

    return view('admin.users.add');
}

public function storeUser(Request $request)
{
    // dd($request->all());
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id' => 'required|exists:roles,id',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    User::create($validated);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
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
    }

    /**
     * Menghapus user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
    }


    public function setting()
    {
        $admin = Auth::user(); // Pastikan auth middleware aktif
        return view('admin.setting', compact('admin'));
    }
    
    public function updateSetting(Request $request)
    {
        $admin = Auth::user(); // Ambil user yang sedang login
    
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
    
        // Perbaiki update dengan menggunakan find()
        $admin = User::find($admin->id);
        
        if ($admin) {
            $admin->update($validated);
            return redirect()->route('admin.setting')->with('success', 'Pengaturan berhasil diperbarui!');
        }
    
        return redirect()->route('admin.setting')->with('error', 'Gagal memperbarui pengaturan.');
    }
    
}