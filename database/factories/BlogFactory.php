<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\User;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        // URL gambar
        $landscapeUrl = "https://cdn.oneesports.id/cdn-data/sites/2/2023/09/SoloLeveling_Anime_Jinwoo_back-1-1024x576-1.jpg";
        $portraitUrl = "https://static.zerochan.net/Sung.Jin-woo.full.3537826.jpg";

        // Nama file unik
        $landscapeFilename = 'images/landscape_' . Str::random(10) . '.jpg';
        $portraitFilename = 'images/portrait_' . Str::random(10) . '.jpg';

        // Download dan simpan di storage
        Storage::disk('public')->put($landscapeFilename, file_get_contents($landscapeUrl));
        Storage::disk('public')->put($portraitFilename, file_get_contents($portraitUrl));

        return [
            'title' => $this->faker->sentence,
            'landscape_image' => 'storage/' . $landscapeFilename, // Path yang bisa diakses
            'portrait_image' => 'storage/' . $portraitFilename,
            'description' => $this->faker->paragraph,
            'full_content' => $this->faker->text(1000),
            'author_id' => User::factory(),
            'published_at' => $this->faker->date(),
        ];
    }
}