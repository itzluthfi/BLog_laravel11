<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
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
        $authors = Auth::user();
        return view('blog.create', compact('authors'));
    }

   
    public function store(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        $validated['author_id'] = Auth::id();
        $validated['published_at'] = now(); 
    
        // Simpan ke database
        Blog::create($validated);
    
        return redirect()->route('profile.artikelSaya')->with('success', 'Blog berhasil ditambahkan!');
    }
    
    
   
    public function show(Blog $blog)
    {
        return view('blog.detail', compact('blog'));
    }

   
    public function edit(Blog $blog)
    {
        $authors = User::all();
        return view('blog.edit', compact('blog'));
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
            // 'published_at' => 'required|date',
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
    
        // Update data blog
        $blog->update($validated);
    
        return redirect()->route('profile.artikelSaya')->with('success', 'Artikel berhasil diperbarui!');
    }
    

    public function destroy(Blog $blog)
    {
        if ($blog->landscape_image) {
            Storage::disk('public')->delete($blog->landscape_image);
        }
        if ($blog->portrait_image) {
            Storage::disk('public')->delete($blog->portrait_image);
        }

        $blog->delete();

        return redirect()->route('profile.artikelSaya')->with('success', 'Blog berhasil dihapus!');
    }

    /**
     * Download and save image from a given URL.
     */
    private function saveImageFromUrl($url, $prefix)
    {
        $imageContents = file_get_contents($url);
        $imageName = $prefix . '_' . time() . '.jpg';
        $path = 'blog_images/' . $imageName;
        Storage::disk('public')->put($path, $imageContents);
        return $path;
    }
}