<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@seapass.com',
            'password' => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator SeaPass',
            'status' => 'active',
        ]);

        // Tambahkan admin lain jika perlu
        Admin::create([
            'username' => 'superadmin',
            'email' => 'superadmin@seapass.com',
            'password' => Hash::make('super123'),
            'nama_lengkap' => 'Super Administrator',
            'status' => 'active',
        ]);
    }
}