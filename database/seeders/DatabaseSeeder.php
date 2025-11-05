<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OperatorSeeder::class,
            KapalSeeder::class,
            JadwalKapalSeeder::class,
            AdminSeeder::class,
            TiketSeeder::class, 
        ]);

        $this->command->info('');
        $this->command->info('================================================');
        $this->command->info('✓ All seeders completed successfully!');
        $this->command->info('================================================');

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
