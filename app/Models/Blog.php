<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    // Tentukan kolom mana yang dapat diisi (fillable)
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

    // Setter untuk otomatis membuat slug dari title
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    

     // Akses Gambar dengan URL Storage
    //  public function getLandscapeImageUrlAttribute()
    //  {
    //      return Storage::url($this->landscape_image);
    //  }
 
    //  public function getPortraitImageUrlAttribute()
    //  {
    //      return Storage::url($this->portrait_image);
    //  }
}