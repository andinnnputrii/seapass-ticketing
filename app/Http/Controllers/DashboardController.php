<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get selected month (default: current month)
        $selectedMonth = $request->input('month', date('n')); // 1-12
        $selectedYear = $request->input('year', date('Y'));

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

        // Data chart berdasarkan bulan yang dipilih
        $chart = $this->getChartDataByMonth($selectedMonth, $selectedYear);

        // Weekly breakdown
        $weeklyBreakdown = $this->generateWeeklyBreakdown(
            $chart['express'],
            $chart['regular']
        );

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
        ];

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

        return view('dashboard.index', compact('stats', 'chart', 'weeklyBreakdown', 'schedule', 'menuItems'));
    }

    /**
     * Get chart data berdasarkan bulan yang dipilih
     */
    private function getChartDataByMonth($month, $year)
    {
        // Hitung jumlah hari dalam bulan tersebut
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        $labels = [];
        $expressData = [];
        $regularData = [];

        // Cek apakah tabel ada dan ada data
        try {
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($year, $month, $day);
                $labels[] = $day;

                // Query Express
                $express = DB::table('kendiarans')
                    ->join('transactions', 'kendiarans.transaksi_id', '=', 'transactions.id')
                    ->whereYear('transactions.created_at', $year)
                    ->whereMonth('transactions.created_at', $month)
                    ->whereDay('transactions.created_at', $day)
                    ->where('transactions.payment_status', 'paid')
                    ->where('kendiarans.jenis_kendaraan', 'Express')
                    ->sum('kendiarans.jumlah');

                // Query Regular
                $regular = DB::table('kendiarans')
                    ->join('transactions', 'kendiarans.transaksi_id', '=', 'transactions.id')
                    ->whereYear('transactions.created_at', $year)
                    ->whereMonth('transactions.created_at', $month)
                    ->whereDay('transactions.created_at', $day)
                    ->where('transactions.payment_status', 'paid')
                    ->where('kendiarans.jenis_kendaraan', 'Regular')
                    ->sum('kendiarans.jumlah');

                $expressData[] = (int) $express;
                $regularData[] = (int) $regular;
            }

            // Jika semua data kosong, gunakan dummy
            if (array_sum($expressData) == 0 && array_sum($regularData) == 0) {
                throw new \Exception('No data');
            }

        } catch (\Exception $e) {
            // Fallback ke data dummy berdasarkan bulan
            $dummyData = $this->getDummyDataByMonth($month, $daysInMonth);
            return $dummyData;
        }

        return [
            'labels' => $labels,
            'express' => $expressData,
            'regular' => $regularData,
        ];
    }

    /**
     * Generate dummy data berdasarkan bulan
     */
    private function getDummyDataByMonth($month, $daysInMonth)
    {
        $labels = range(1, $daysInMonth);
        $expressData = [];
        $regularData = [];

        // Variasi data berdasarkan bulan
        $monthMultiplier = [
            5 => 1.2,  // Mei - high season
            6 => 1.0,  // Juni
            7 => 1.5,  // Juli - peak season
            8 => 1.3,  // Agustus
            9 => 0.9,  // September
            10 => 0.8, // Oktober
            11 => 1.1, // November
            12 => 1.4, // Desember
        ];

        $multiplier = $monthMultiplier[$month] ?? 1.0;

        for ($i = 0; $i < $daysInMonth; $i++) {
            $baseExpress = rand(150, 550);
            $baseRegular = rand(100, 350);

            $expressData[] = round($baseExpress * $multiplier);
            $regularData[] = round($baseRegular * $multiplier);
        }

        return [
            'labels' => $labels,
            'express' => $expressData,
            'regular' => $regularData,
        ];
    }

    /**
     * Generate weekly breakdown
     */
    private function generateWeeklyBreakdown($expressData, $regularData)
    {
        $breakdown = [];

        foreach ($expressData as $index => $expressTotal) {
            $regularTotal = $regularData[$index] ?? 0;

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
     * API endpoint untuk filter bulan via AJAX
     */
    public function filterByMonth(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $chart = $this->getChartDataByMonth($month, $year);
        $weeklyBreakdown = $this->generateWeeklyBreakdown($chart['express'], $chart['regular']);

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $chart['labels'],
                'datasets' => [
                    'express' => $chart['express'],
                    'regular' => $chart['regular'],
                ],
                'weeklyBreakdown' => $weeklyBreakdown
            ]
        ]);
    }

    public function getBreakdownDetail(Request $request)
    {
        $dayIndex = $request->input('day_index');

        $chart = $this->getChartDataByMonth(date('n'), date('Y'));
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
    }
}
