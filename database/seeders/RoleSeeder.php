<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->insert([
            ['name' => 'User', 'status' => 1],  // 1 = Active
            ['name' => 'Admin', 'status' => 1], // 1 = Active
            ['name' => 'Superadmin', 'status' => 1], // 1 = Active
            ['name' => 'Manager', 'status' => 0], // 1 = Active
        ]);
    }
}