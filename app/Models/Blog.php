<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    // Tentukan kolom mana yang dapat diisi (fillable)
    protected $fillable = [
        'title', 
        'image', 
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
    
    
    // Tentukan relasi dengan model User (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

     // Akses Gambar dengan URL Storage
     public function getLandscapeImageUrlAttribute()
     {
         return Storage::url($this->landscape_image);
     }
 
     public function getPortraitImageUrlAttribute()
     {
         return Storage::url($this->portrait_image);
     }
}