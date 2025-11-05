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

        $chart = [
            'labels' => range(1, 30),
            'express' => [120,140,160,220,460,310,280,260,300,350,290,400,480,150,220,500,520,480,510,470,530,560,420,390,300,250,200,280,320,360],
            'regular' => [90,80,150,100,130,200,240,210,220,230,250,260,270,300,310,330,290,310,320,340,300,280,260,250,240,230,220,210,200,190],
        ];

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

        return view('dashboard.index', compact('stats', 'chart', 'schedule', 'menuItems'));
    }
}
