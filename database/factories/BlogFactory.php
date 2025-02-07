<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Tentukan model yang terkait dengan factory ini
     *
     * @return string
     */
    protected $model = \App\Models\Blog::class;

    /**
     * Tentukan state default untuk model ini
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(640, 480, 'blog', true),  // Menghasilkan URL gambar acak
            'portrait_image' => $this->faker->imageUrl(640, 960, 'blog', true),  // Menghasilkan URL gambar portrait acak
            'description' => $this->faker->paragraph,
            'full_content' => $this->faker->paragraphs(3, true),  // Menghasilkan teks panjang
            'author_id' => User::factory(),  // Menggunakan factory untuk menghasilkan user acak
            'published_at' => $this->faker->date,  // Menghasilkan tanggal acak
        ];
    }
}