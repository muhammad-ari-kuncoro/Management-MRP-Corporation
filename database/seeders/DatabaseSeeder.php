<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


      // Pengguna Admin
      User::create([
        'name' => 'User Admin',
        'email' => 'admin@admin.com',
        'address_user' => 'In world company World',
        'password' => Hash::make('12345'),
        'number_phone' => '081234567890', // Pastikan kolom wajib diisi
        'group' => 'Developer Team',     // Pastikan kolom wajib diisi
        'city' => 'Jakarta',             // Pastikan kolom wajib diisi

        // ROLE PENTING!
        'user_role' => 'superadmin',
    ]);

    // Pengguna Biasa
    User::create([
        'name' => 'General User',
        'email' => 'user@user.com',
        'address_user' => 'Random Street 123',
        'password' => Hash::make('password'),
        'number_phone' => '089876543210',
        'group' => 'Sales Team',
        'city' => 'Surabaya',

        // ROLE PENTING!
        'user_role' => 'purchasing',
    ]);

    }
}
