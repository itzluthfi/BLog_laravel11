<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

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

        // Insert user spesifik
        User::query()->insert([
            [
                'username' => 'admin_user',
                'email' => 'wangja@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id ?? null,
                'email_verified_at' => now(),
                'created_at' => now(),
            ],
            [
                'username' => 'regular_user',
                'email' => 'freya@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id ?? null,
                'email_verified_at' => now(),
                'created_at' => now(),

            ],
            [
                'username' => 'superadmin_user',
                'email' => 'sidqi961@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => $superAdminRole->id ?? null,
                'email_verified_at' => now(),
                'created_at' => now(),

            ],
        ]);

        // Insert 10 user tambahan menggunakan factory
        User::factory()->count(10)->create();
    }
}