<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blog.index', compact('blogs'));
    }


    public function create()
{
    $categories = Category::all(); // Ambil kategori dari database
    return view('blog.create', compact('categories'));
}

   
    public function store(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'full_content' => 'required|string',
            
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

        $validated['category_id'] = $request->category_id;
        $validated['author_id'] = Auth::id();
        $validated['published_at'] = now(); 
    
        // Simpan ke database
        Blog::create($validated);
    
        return redirect()->route('profile.artikelSaya')->with('success', 'Blog berhasil ditambahkan!');
    }
    
    
   
    public function show(Blog $blog)
    {
        $user = Auth::user();
        $comments = Comment::where('blog_id', $blog->id)
                    ->whereNull('parent_id') // Ambil hanya komentar utama
                    ->with([
                        'user', 
                        'likes', 
                        'replies.user', // Ambil user dari balasan
                        'replies.likes' // Ambil likes dari balasan
                    ])
                    ->latest() // Urutkan komentar utama dari terbaru
                    ->get();
    
        return view('blog.detail', compact('blog', 'comments'));
    }
    

   
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('blog.edit', compact('blog', 'categories'));
    }



    public function storeImageContent(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/uploads');
    
            // Pastikan direktori ada sebelum memindahkan file
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
    
            // Pindahkan file ke storage/uploads
            $file->move($destinationPath, $filename);
    
            return response()->json(['url' => asset('storage/uploads/' . $filename)]);
        }
    
        return response()->json(['error' => 'No file uploaded'], 400);
    }
    
    


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $blog = Blog::findOrFail($id);
    
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'full_content' => 'required|string',
            // 'category_id' => 'required|exists:categories,id',
            'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle Gambar Header
        if ($request->hasFile('landscape_image')) {
            if ($request->old_landscape_image && file_exists(public_path($request->old_landscape_image))) {
                unlink(public_path($request->old_landscape_image));
                // dd("file lama berhasil di hapus!", $request->old_landscape_image);
            }
            // else{
            //     dd("file lama tidak ditemukan!");
            // }
    
            $file = $request->file('landscape_image');
            $filename = 'landscape_' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('storage/blog_images'), $filename);
            $validated['landscape_image'] = 'storage/blog_images/' . $filename;
        } else {
            // Tetap gunakan gambar lama jika tidak ada perubahan
            $validated['landscape_image'] = $blog->landscape_image;
        }
    
        // Handle Gambar Portrait
        if ($request->hasFile('portrait_image')) {
            if ($request->old_portrait_image && file_exists(public_path($request->old_portrait_image))) {
                unlink(public_path($request->old_portrait_image));
            }
    
            $file = $request->file('portrait_image');
            $filename = 'portrait_' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('storage/blog_images'), $filename);
            $validated['portrait_image'] = 'storage/blog_images/' . $filename;
        } else {
            // Tetap gunakan gambar lama jika tidak ada perubahan
            $validated['portrait_image'] = $blog->portrait_image;
        }
    
        // $validated['category_id'] = $request->category_id;
        
        // Update data blog
        $blog->update($validated);
    
        return redirect()->route('profile.artikelSaya')->with('success', 'Artikel berhasil diperbarui!');
    }
    

    public function destroy(Blog $blog)
    {
        if ($blog->author_id !== Auth::id()) {
            return redirect()->route('profile.artikelSaya')->with('error', 'Anda tidak berhak menghapus artikel ini.');
        }

        if ($blog->landscape_image && Storage::disk('public')->exists($blog->landscape_image)) {
            Storage::disk('public')->delete($blog->landscape_image);
        }

        $blog->delete();

        return redirect()->route('profile.artikelSaya')->with('success', 'Artikel berhasil dihapus.');
    }

   
     /**
     * Menambah atau menghapus blog dari favorit.
     */
    public function favorite($blogId)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
                            ->where('blog_id', $blogId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Blog dihapus dari favorit.');
        }

        Favorite::create([
            'user_id' => $user->id,
            'blog_id' => $blogId,
        ]);

        return back()->with('success', 'Blog berhasil ditambahkan ke favorit!');
    }
}