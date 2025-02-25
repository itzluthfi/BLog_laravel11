<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\User;
use App\Models\Blog;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory()->create()->id,
            'blog_id' => Blog::query()->inRandomOrder()->value('id') ?? Blog::factory()->create()->id,
            'content' => $this->faker->paragraph,
            'parent_id' => null, // Untuk komentar utama
        ];
    }
}