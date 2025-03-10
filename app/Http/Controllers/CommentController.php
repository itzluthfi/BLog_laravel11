<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   
    /**
     * Menampilkan semua komentar untuk blog tertentu.
     */
    public function index($blogId)
    {
        $comments = Comment::where('blog_id', $blogId)
            ->with(['user', 'likes'])
            ->latest()
            ->get();

        return view('blog.detail', compact('comments', 'blogId'));
    }

        /**
         * Menyimpan komentar baru.
         */
        public function store(Request $request, Blog $blog)
        {
            // Validasi dan simpan komentar
            $validated = $request->validate([
                'content' => 'required|string|max:500',
                'parent_id' => 'nullable|exists:comments,id',
            ]);
        
            $validated['blog_id'] = $blog->id;
            $validated['user_id'] = Auth::id();
        
            $comment = Comment::create($validated);
        
            // Respons untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'id' => $comment->id,
                    'user_id' => $comment->user_id,
                    'username' => Auth::user()->username,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'parent_id' => $comment->parent_id // Tambahkan jika diperlukan
                ]);
            }
        
            return back()->with('success', 'Komentar berhasil ditambahkan!');
        }

  

        public function update(Request $request, Comment $comment)
        {
            abort_if(Auth::id() !== $comment->user_id, 403, 'Anda tidak memiliki izin untuk memperbarui komentar ini.');
        
            $validated = $request->validate([
                'content' => 'required|string|max:500',
            ]);
        
            $comment->update(['content' => $validated['content']]);
        
            return back()->with('success', 'Komentar berhasil diperbarui!');

        }
        
        

    /**
     * Menghapus komentar.
     */
    public function destroy(Comment $comment)
    {
        abort_if(Auth::id() !== $comment->user_id, 403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Menyukai atau membatalkan like pada komentar.
     */
    public function like(Comment $comment)
    {
        $userId = Auth::id();
        $like = $comment->likes()->where('user_id', $userId);

        abort_if(!$comment, 404, 'Komentar tidak ditemukan.');

        if ($like->exists()) {
            $like->delete();
            return back()->with('success', 'Like pada komentar dibatalkan.');
        }

        $comment->likes()->create(['user_id' => $userId]);

        return back()->with('success', 'Komentar berhasil disukai!');
    }
}