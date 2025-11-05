<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy Customers
        $customers = [
            [
                'name' => 'Fajar Nugraha',
                'email' => 'fajar.n@gmail.com',
                'phone' => '+62812345678',
                'password' => Hash::make('password'),
                'status' => 'verified',
                'total_trips' => 15,
                'last_login' => now()->subDays(2),
                'created_at' => now()->subMonths(10),
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.w@yahoo.com',
                'phone' => '+62823456789',
                'password' => Hash::make('password'),
                'status' => 'verified',
                'total_trips' => 8,
                'last_login' => now()->subDay(),
                'created_at' => now()->subMonths(7),
            ],
            [
                'name' => 'Indah Sari',
                'email' => 'indah.sari@gmail.com',
                'phone' => '+62834567890',
                'password' => Hash::make('password'),
                'status' => 'unverified',
                'total_trips' => 2,
                'last_login' => now()->subDays(5),
                'created_at' => now()->subMonths(1),
            ],
            [
                'name' => 'Joko Susanto',
                'email' => 'joko.s@outlook.com',
                'phone' => '+62845678901',
                'password' => Hash::make('password'),
                'status' => 'suspended',
                'total_trips' => 22,
                'last_login' => now()->subMonths(2),
                'created_at' => now()->subMonths(15),
            ],
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }
    }
}