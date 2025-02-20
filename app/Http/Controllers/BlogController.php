<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = User::all();
        return view('blog.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'landscape_image' => 'nullable|url',
            'portrait_image' => 'nullable|url',
            'description' => 'required|string',
            'full_content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'nullable|date',
        ]);

        if ($request->filled('landscape_image')) {
            $validated['landscape_image'] = $this->saveImageFromUrl($request->landscape_image, 'landscape');
        }
        if ($request->filled('portrait_image')) {
            $validated['portrait_image'] = $this->saveImageFromUrl($request->portrait_image, 'portrait');
        }

        Blog::create($validated);

        return redirect()->route('blog.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('blog.detail', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $authors = User::all();
        return view('blog.edit', compact('blog', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'landscape_image' => 'nullable|url',
            'portrait_image' => 'nullable|url',
            'description' => 'required|string',
            'full_content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'published_at' => 'nullable|date',
        ]);

        if ($request->filled('landscape_image')) {
            if ($blog->landscape_image) {
                Storage::disk('public')->delete($blog->landscape_image);
            }
            $validated['landscape_image'] = $this->saveImageFromUrl($request->landscape_image, 'landscape');
        }
        if ($request->filled('portrait_image')) {
            if ($blog->portrait_image) {
                Storage::disk('public')->delete($blog->portrait_image);
            }
            $validated['portrait_image'] = $this->saveImageFromUrl($request->portrait_image, 'portrait');
        }

        $blog->update($validated);

        return redirect()->route('blog.index')->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->landscape_image) {
            Storage::disk('public')->delete($blog->landscape_image);
        }
        if ($blog->portrait_image) {
            Storage::disk('public')->delete($blog->portrait_image);
        }

        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Blog berhasil dihapus!');
    }

    /**
     * Download and save image from a given URL.
     */
    private function saveImageFromUrl($url, $prefix)
    {
        $imageContents = file_get_contents($url);
        $imageName = $prefix . '_' . time() . '.jpg';
        $path = 'images/' . $imageName;
        Storage::disk('public')->put($path, $imageContents);
        return $path;
    }
}