<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID dari Role berdasarkan nama
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole = Role::where('name', 'User')->first();
        $superAdminRole = Role::where('name', 'Superadmin')->first();

        // Fungsi untuk mengunduh dan menyimpan gambar profil
        function downloadProfileImage($email)
        {
            $avatarUrl = "https://i.pravatar.cc/50?u=" . md5($email);
            $imageName = 'user_images/profile_' . Str::random(10) . '.jpg';

            $imageContents = @file_get_contents($avatarUrl);
            if ($imageContents !== false) {
                Storage::disk('public')->put($imageName, $imageContents);
                return 'storage/'.$imageName;
            }

            return 'user_images/default.jpg'; // Jika gagal, pakai default
        }

        // Insert user spesifik dengan gambar profil
        User::query()->insert([
            [
                'username' => 'admin_user',
                'email' => 'wangja@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id ?? null,
                'email_verified_at' => now(),
                'profile_image' => downloadProfileImage('wangja@gmail.com'),
                'created_at' => now(),
            ],
            [
                'username' => 'regular_user',
                'email' => 'freya@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id ?? null,
                'email_verified_at' => now(),
                'profile_image' => downloadProfileImage('freya@gmail.com'),
                'created_at' => now(),
            ],
            [
                'username' => 'superadmin_user',
                'email' => 'sidqi961@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id ?? null,
                'email_verified_at' => now(),
                'profile_image' => downloadProfileImage('sidqi961@gmail.com'),
                'created_at' => now(),
            ],
        ]);

        // Insert 10 user tambahan menggunakan factory
        User::factory()->count(10)->create();
    }
}