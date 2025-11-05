<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Schedule;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default periode: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        
        // Convert to Carbon instances
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // 1. STATISTIK PENJUALAN TIKET
        $salesStats = $this->getSalesStats($start, $end);

        // 2. DATA GRAFIK PENJUALAN TIKET (30 hari terakhir)
        $salesChartData = $this->getSalesChartData($start, $end);

        // 3. PENDAPATAN TIKET (Pie Chart)
        $revenueByMethod = $this->getRevenueByMethod($start, $end);

        // 4. RUTE PENUMPANG TERLAYARKAN (Bar Chart)
        $routeStats = $this->getRouteStats($start, $end);

        // 5. PENDAPATAN KAPAL (Tabel)
        $shipRevenue = $this->getShipRevenue($start, $end);

        return view('admin.reports.index', compact(
            'salesStats',
            'salesChartData',
            'revenueByMethod',
            'routeStats',
            'shipRevenue',
            'startDate',
            'endDate'
        ));
    }

    private function getSalesStats($start, $end)
    {
        $transactions = Transaction::whereBetween('created_at', [$start, $end])
            ->where('payment_status', 'paid');

        return [
            'total_sales' => $transactions->sum('amount'),
            'total_tickets' => $transactions->count(),
            'total_passengers' => $transactions->count(),
            'avg_transaction' => $transactions->avg('amount'),
        ];
    }

    private function getSalesChartData($start, $end)
    {
        // Data penjualan per hari (30 hari)
        $days = [];
        $express = [];
        $regular = [];

        for ($i = 0; $i < 30; $i++) {
            $date = $start->copy()->addDays($i);
            $days[] = $date->format('d');

            // Simulasi data Express & Regular (nanti sesuaikan dengan tabel kamu)
            $dailySales = Transaction::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->count();

            $express[] = rand(100, 500);
            $regular[] = rand(50, 300);
        }

        return [
            'labels' => $days,
            'express' => $express,
            'regular' => $regular,
        ];
    }

    private function getRevenueByMethod($start, $end)
    {
        $revenue = Transaction::whereBetween('created_at', [$start, $end])
            ->where('payment_status', 'paid')
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get();

        return [
            'labels' => $revenue->pluck('payment_method')->toArray(),
            'data' => $revenue->pluck('total')->toArray(),
        ];
    }

    private function getRouteStats($start, $end)
    {
        // Dummy data untuk route stats (nanti sesuaikan dengan relasi schedule)
        return [
            'labels' => ['Muara - Surabaya', 'Ketapang - Banyuwangi', 'Jakarta - Batam', 'Jakarta - Ambon'],
            'data' => [745, 543, 412, 324],
        ];
    }

    private function getShipRevenue($start, $end)
    {
        // Dummy data pendapatan kapal (nanti integrasikan dengan tabel ships & schedules)
        return [
            [
                'ship_name' => 'KM Bahari',
                'route' => 'Muara - Bakauheni',
                'active_schedules' => 30,
                'total_tickets' => 6800,
                'revenue' => 1300000000,
            ],
            [
                'ship_name' => 'KM Lambelu',
                'route' => 'Ketapang - Gilimanuk',
                'active_schedules' => 28,
                'total_tickets' => 5800,
                'revenue' => 1100000000,
            ],
            [
                'ship_name' => 'KM Mariana Raya',
                'route' => 'Ujung - Kamal',
                'active_schedules' => 25,
                'total_tickets' => 2800,
                'revenue' => 580000000,
            ],
            [
                'ship_name' => 'KM Teluk Indah',
                'route' => 'Ajibata - Ambarita',
                'active_schedules' => 20,
                'total_tickets' => 1400,
                'revenue' => 280000000,
            ],
            [
                'ship_name' => 'KM MTB Expresss',
                'route' => 'Kayangan - Pulau Tandu',
                'active_schedules' => 18,
                'total_tickets' => 1800,
                'revenue' => 360000000,
            ],
        ];
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'pdf'); // pdf or excel
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // TODO: Implementasi export PDF/Excel
        return response()->json(['message' => 'Export coming soon!']);
    }
}