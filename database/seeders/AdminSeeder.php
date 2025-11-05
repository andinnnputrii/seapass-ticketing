<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@seapass.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',       
            'status' => 'active',     
        ]);

        // Tambah operator dummy
        Admin::create([
            'nama_lengkap' => 'Putri andini',
            'username' => 'operator1',
            'email' => 'putri.andini@seapass.com',
            'password' => Hash::make('operator123'),
            'role' => 'operator',
            'status' => 'active',
        ]);
    }
}