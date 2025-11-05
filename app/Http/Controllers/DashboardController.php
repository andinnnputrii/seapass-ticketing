<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'ticketsToday' => 1265,
            'passengersToday' => 1098,
            'expressTotal' => 5870,
            'regularTotal' => 3700,
            'opsRate' => 0.90,
            'revenue' => 178250000,
            'trendTickets' => 0.035,
            'trendPassengers' => 0.048,
            'trendRevenue' => -0.012,
        ];

<<<<<<< HEAD
        // Data overview untuk chart (30 hari)
=======
>>>>>>> 9e94dabede9e59c6c55d80a4118e682c1d0e66a2
        $chart = [
            'labels' => range(1, 30),
            'express' => [120,140,160,220,460,310,280,260,300,350,290,400,480,150,220,500,520,480,510,470,530,560,420,390,300,250,200,280,320,360],
            'regular' => [90,80,150,100,130,200,240,210,220,230,250,260,270,300,310,330,290,310,320,340,300,280,260,250,240,230,220,210,200,190],
        ];

<<<<<<< HEAD
        // Data drill-down: breakdown mingguan untuk setiap tanggal (30 titik)
        // Format: setiap tanggal punya 4 minggu breakdown
        $weeklyBreakdown = $this->generateWeeklyBreakdown($chart['express'], $chart['regular']);

=======
>>>>>>> 9e94dabede9e59c6c55d80a4118e682c1d0e66a2
        $schedule = [
            [
                'id' => 'J001','ship' => 'KM Tidar','from' => 'Tanjung Perak','to' => 'Tanjung Emas',
                'depart' => '07:00 WIB','eta' => '13:00 WIB','status' => 'On-Time','status_color' => 'teal',
                'note' => 'Cerah, sesuai jadwal'
            ],
            [
                'id' => 'J002','ship' => 'KM Laut Jaya','from' => 'Banten','to' => 'Bakauheni',
                'depart' => '12:30 WIB','eta' => '18:30 WIB','status' => 'Delay','status_color' => 'amber',
                'note' => 'Cuaca buruk'
            ],
            [
                'id' => 'J003','ship' => 'KM Nusantara','from' => 'Gilimanuk','to' => 'Ketapang',
                'depart' => '14:00 WIB','eta' => '16:00 WIB','status' => 'On-Time','status_color' => 'teal',
                'note' => 'Kapal Siap'
            ],
            [
                'id' => 'J004','ship' => 'KM Jaya Kusuma','from' => 'Surabaya','to' => 'Makassar',
                'depart' => '20:00 WIB','eta' => '12:00 WITA','status' => 'On-Time','status_color' => 'teal',
                'note' => 'Kapal Siap'
            ],
            [
                'id' => 'J005','ship' => 'KM Jaya Kusuma','from' => 'Padangbai','to' => 'Lembar',
                'depart' => '06:00 WITA','eta' => '08:00 WITA','status' => 'On-Time','status_color' => 'teal',
                'note' => 'Kapal Siap'
            ],
        ];

        // Menu items dipakai oleh layout
        $menuItems = [
            ['label'=>'Dashboard','icon'=>'grid','route'=>route('dashboard')],
            ['label'=>'Kapal & Operator','icon'=>'anchor','route'=>'#'],
            ['label'=>'Jadwal Kapal','icon'=>'calendar','route'=>'#'],
            ['label'=>'Tiket & Validasi','icon'=>'ticket','route'=>'#'],
            ['label'=>'Data Penumpang','icon'=>'users','route'=>'#'],
            ['label'=>'Transaksi & Refund','icon'=>'credit-card','route'=>'#'],
            ['label'=>'Laporan & Analitik','icon'=>'bar-chart-2','route'=>'#'],
            ['label'=>'Pengguna & Akses','icon'=>'shield','route'=>'#'],
            ['label'=>'Pengaduan','icon'=>'message-square','route'=>'#'],
            ['label'=>'Pengaturan Sistem','icon'=>'settings','route'=>'#'],
        ];

<<<<<<< HEAD
        return view('dashboard.index', compact('stats', 'chart', 'weeklyBreakdown', 'schedule', 'menuItems'));
    }

    /**
     * Generate weekly breakdown data untuk drill-down
     * Setiap hari dipecah menjadi 4 periode (pagi, siang, sore, malam)
     *
     * @param array $expressData
     * @param array $regularData
     * @return array
     */
    private function generateWeeklyBreakdown($expressData, $regularData)
    {
        $breakdown = [];

        foreach ($expressData as $index => $expressTotal) {
            $regularTotal = $regularData[$index] ?? 0;

            // Distribusi data menjadi 4 periode dalam sehari
            // Menggunakan variasi realistis: pagi (25%), siang (30%), sore (28%), malam (17%)
            $breakdown[$index] = [
                'express' => [
                    round($expressTotal * 0.25 + rand(-10, 10)),
                    round($expressTotal * 0.30 + rand(-10, 10)),
                    round($expressTotal * 0.28 + rand(-10, 10)),
                    round($expressTotal * 0.17 + rand(-10, 10)),
                ],
                'regular' => [
                    round($regularTotal * 0.25 + rand(-10, 10)),
                    round($regularTotal * 0.30 + rand(-10, 10)),
                    round($regularTotal * 0.28 + rand(-10, 10)),
                    round($regularTotal * 0.17 + rand(-10, 10)),
                ],
            ];
        }

        return $breakdown;
    }

    /**
     * API endpoint untuk mendapatkan detail breakdown (opsional)
     * Berguna jika ingin fetch data drill-down via AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreakdownDetail(Request $request)
    {
        $dayIndex = $request->input('day_index');

        // Dalam implementasi real, query dari database
        // Contoh: SELECT * FROM ticket_sales WHERE day = $dayIndex GROUP BY time_period

        $chart = [
            'labels' => range(1, 30),
            'express' => [120,140,160,220,460,310,280,260,300,350,290,400,480,150,220,500,520,480,510,470,530,560,420,390,300,250,200,280,320,360],
            'regular' => [90,80,150,100,130,200,240,210,220,230,250,260,270,300,310,330,290,310,320,340,300,280,260,250,240,230,220,210,200,190],
        ];

        $weeklyBreakdown = $this->generateWeeklyBreakdown($chart['express'], $chart['regular']);

        if (isset($weeklyBreakdown[$dayIndex])) {
            return response()->json([
                'success' => true,
                'data' => $weeklyBreakdown[$dayIndex],
                'labels' => ['Pagi (06-10)', 'Siang (10-14)', 'Sore (14-18)', 'Malam (18-22)']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
        return view('dashboard.index', compact('stats', 'chart', 'schedule', 'menuItems'));
    }
}
