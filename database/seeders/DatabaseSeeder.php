<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserManagementSeeder::class,
            OperatorSeeder::class,
            KapalSeeder::class,
            JadwalKapalSeeder::class,
            TiketSeeder::class,
            TransactionSeeder::class,
        ]);

        // Seeder sukses info
        $this->command->info('');
        $this->command->info('✓ All seeders completed successfully!');
        $this->command->info('');

        // Tambahkan 1 user dummy
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
