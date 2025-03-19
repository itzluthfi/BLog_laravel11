<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'profile_image',
        'username',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

      // Relasi Many-to-Many ke Blog untuk Like
      public function likedBlogs() {
        return $this->belongsToMany(Blog::class, 'blog_likes')->withTimestamps();
    }

    // Relasi Many-to-Many ke Blog untuk Favorite
    public function favoriteBlogs() {
        return $this->belongsToMany(Blog::class, 'blog_favorites')->withTimestamps();
    }

    public function hasLiked(Blog $blog)
    {
        return $this->likedBlogs()->where('blog_id', $blog->id)->exists();
    }

    public function hasFavorited(Blog $blog)
    {
        return $this->favoriteBlogs()->where('blog_id', $blog->id)->exists();
    }

}