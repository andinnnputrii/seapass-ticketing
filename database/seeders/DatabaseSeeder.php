<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan semua seeder yang kamu miliki
        $this->call([
            AdminSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
