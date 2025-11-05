<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> 5dbb5e9b770a1d1b6c8c08ef2fa4d8432bd2a547
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        $this->call([
            OperatorSeeder::class,
            KapalSeeder::class,
            JadwalKapalSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('================================================');
        $this->command->info('✓ All seeders completed successfully!');
        $this->command->info('================================================');
=======
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
>>>>>>> 5dbb5e9b770a1d1b6c8c08ef2fa4d8432bd2a547
    }
}
