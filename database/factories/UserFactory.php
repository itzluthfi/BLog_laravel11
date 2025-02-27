<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $avatarsUrl = "https://i.pravatar.cc/50?u=" . $this->faker->unique()->randomNumber();
        $imageName = 'user_images/profile_' . Str::random(10) . '.jpg';
        
        // Download dan simpan di storage
        Storage::disk('public')->put($imageName, file_get_contents($avatarsUrl));
    
        return [
            'username' => $this->faker->userName(),
            'profile_image' => 'storage/'.$imageName, // Simpan path gambar
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => Role::inRandomOrder()->first()->id ?? 1,
            'remember_token' => Str::random(10),
        ];
    }
    
}