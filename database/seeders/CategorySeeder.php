<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Media Sosial',
            'Hiburan Digital',
            'Teknologi AI',
            'Olahraga Sehat',
            'Pendidikan Modern',
            'Kesehatan Digital',
            'Bisnis Online'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}