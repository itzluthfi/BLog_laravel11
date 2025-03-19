<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'category_id',
        'landscape_image', 
        'portrait_image', 
        'description', 
        'full_content', 
        'author_id', 
        'published_at'
    ];


    // ✅ Cast `published_at` ke Carbon
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

     // Relasi Many-to-Many dengan User untuk Like
     public function likes() {
        return $this->belongsToMany(User::class, 'blog_likes')->withTimestamps();
    }

    // Relasi Many-to-Many dengan User untuk Favorite
    public function favorites() {
        return $this->belongsToMany(User::class, 'blog_favorites')->withTimestamps();
    }

      // Cek apakah user telah menyukai blog ini
      public function isLikedBy(User $user) {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Cek apakah user telah memfavoritkan blog ini
    public function isFavoritedBy(User $user) {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    // Setter untuk otomatis membuat slug dari title
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
}