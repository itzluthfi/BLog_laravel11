<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blog_id', 'content', 'parent_id'];

    protected $casts = [
        'user_id' => 'integer',
        'blog_id' => 'integer',
        'parent_id' => 'integer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // Relasi ke Like (suka pada komentar)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relasi ke komentar balasan (replies)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}