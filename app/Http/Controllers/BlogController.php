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
use Yajra\DataTables\DataTables;
use Exception;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::with('category', 'author')->latest()->get();
            $categories = Category::all();

            return view('blog.index', compact('blogs', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat daftar blog: ' . $e->getMessage());
        }
    }
    public function indexTemplate()
    {
        try {
            $blogs = Blog::latest()->get();
            $categories = Category::latest()->get();
            return view('admin.blogs.listTemplate', compact('blogs', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat daftar blog: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();
            return view('blog.create', compact('categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat halaman tambah blog: ' . $e->getMessage());
        }
    }

    public function data()
    {
        $blogs = Blog::with(['category', 'author'])->latest();

        return datatables()
            ->eloquent($blogs)
            ->addIndexColumn()
            ->addColumn('category', function ($blog) {
                return $blog->category ? $blog->category->name : '-';
            })
            ->addColumn('author', function ($blog) {
                return $blog->author ? $blog->author->username : '-';
            })
            ->addColumn('action', function ($blog) {
                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store(Request $request)
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

            return redirect()->route('profile.artikelSaya')->with('success', 'Blog berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Blog $blog)
    {
        try {
            $comments = Comment::where('blog_id', $blog->id)
                ->whereNull('parent_id')
                ->with(['user', 'likes', 'replies.user', 'replies.likes'])
                ->latest()
                ->get();

            return view('blog.detail', compact('blog', 'comments'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menampilkan detail blog: ' . $e->getMessage());
        }
    }

    public function edit(Blog $blog)
    {
        try {
            $categories = Category::all();
            return view('blog.edit', compact('blog', 'categories'));
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memuat halaman edit blog: ' . $e->getMessage());
        }
    }

    public function storeImageContent(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '-' . $file->getClientOriginalName();
                $destinationPath = public_path('storage/uploads');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $filename);
                return response()->json(['url' => asset('storage/uploads/' . $filename)]);
            }
            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'landscape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'portrait_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'full_content' => 'required|string',
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

            return redirect()->route('profile.artikelSaya')->with('success', 'Blog berhasil diperbarui!');
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

    public function destroy(Blog $blog)
    {
        try {
            if ($blog->author_id !== Auth::id()) {
                return redirect()->route('profile.artikelSaya')->with('error', 'Anda tidak berhak menghapus artikel ini.');
            }

            if ($blog->landscape_image && file_exists(public_path($blog->landscape_image))) {
                unlink(public_path($blog->landscape_image));
            }

            if ($blog->portrait_image && file_exists(public_path($blog->portrait_image))) {
                unlink(public_path($blog->portrait_image));
            }

            $blog->delete();

            return redirect()->route('profile.artikelSaya')->with('success', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus blog.' . $e->getMessage());
        }
    }


    public function like(Blog $blog)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'You must be logged in to perform this action.'], 401);
        }

        // Toggle like (attach jika belum like, detach jika sudah like)
        $user->likedBlogs()->toggle($blog);

        return response()->json([
            'likes' => $blog->likes()->count()
        ]);
    }


    public function favorite(Blog $blog)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'You must be logged in to perform this action.'], 401);
        }

        // Toggle likfavoritee (attach jika belum favorite, detach jika sudah favorite)
        $user->favoriteBlogs()->toggle($blog);

        return response()->json([
            'favorites' => $blog->favorites()->count()
        ]);
    }
}
