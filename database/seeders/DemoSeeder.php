<?php

namespace Database\Seeders;

use App\Models\Ship;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan dulu (opsional untuk demo)
        Ship::query()->delete();
        Schedule::query()->delete();
        Ticket::query()->delete();

        // Buat kapal
        $ships = collect([
            'KM Tidar', 'KM Laut Jaya', 'KM Nusantara', 'KM Jaya Kusuma', 'KM Samudra',
            'KM Bahari', 'KM Nusantara II', 'KM Pelita', 'KM Sejahtera', 'KM Merdeka'
        ])->map(function ($name, $i) {
            return Ship::create([
                'name' => $name,
                'operator' => 'SeaPass',
                'is_operational' => $i % 9 !== 0, // sebagian non-operasional
            ]);
        });

        // Jadwal contoh (5 terdekat)
        $origins = ['Tanjung Perak', 'Banten', 'Gilimanuk', 'Surabaya', 'Padangbai'];
        $dests = ['Tanjung Emas', 'Bakauheni', 'Ketapang', 'Makassar', 'Lembar'];

        $schedules = collect();
        for ($i = 1; $i <= 5; $i++) {
            $dep = now()->startOfDay()->addHours(6 + $i * 3);
            $schedules->push(Schedule::create([
                'code' => 'J' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'ship_id' => $ships[$i-1]->id,
                'origin_port' => $origins[$i-1],
                'dest_port' => $dests[$i-1],
                'departure_at' => $dep,
                'arrival_estimated_at' => $dep->copy()->addHours(5 + $i),
                'status' => $i === 2 ? 'Delay' : 'On-Time',
                'note' => $i === 2 ? 'Cuaca buruk' : 'Kapal Siap',
            ]));
        }

        // Tiket sebulan berjalan: distribusi acak setiap hari
        $monthStart = now()->startOfMonth();
        $days = now()->endOfMonth()->day;

        for ($day = 1; $day <= $days; $day++) {
            $date = $monthStart->copy()->day($day)->setTime(rand(6, 20), rand(0, 59));
            $expressCount = rand(80, 600) / 6; // skala ringan
            $regularCount = rand(60, 450) / 6;

            // Bulatkan
            $expressCount = max(0, (int) round($expressCount));
            $regularCount = max(0, (int) round($regularCount));

            // Ambil schedule acak
            $schedule = $schedules->random();

            for ($i = 0; $i < $expressCount; $i++) {
                Ticket::create([
                    'schedule_id' => $schedule->id,
                    'type' => 'express',
                    'price' => 120000 + rand(0, 30000),
                    'sold_at' => $date->copy()->addMinutes(rand(0, 120)),
                ]);
            }
            for ($i = 0; $i < $regularCount; $i++) {
                Ticket::create([
                    'schedule_id' => $schedule->id,
                    'type' => 'regular',
                    'price' => 80000 + rand(0, 20000),
                    'sold_at' => $date->copy()->addMinutes(rand(0, 120)),
                ]);
            }
        }
    }
}
