<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Tentukan relasi dengan model User (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'id');
    }
}