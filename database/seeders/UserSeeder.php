<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Tambah pengguna admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'), // Pastikan untuk mengganti ini dengan password yang lebih aman
            'level' => 'admin',
        ]);

        // Tambah pengguna biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'level' => 'user',
        ]);
    }
}
