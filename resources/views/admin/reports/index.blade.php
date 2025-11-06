@php
    $formattedSales = 'Rp ' . number_format($formattedSales ?? 0, 0, ',', '.');
@endphp

@extends('layouts.app')

@section('title', 'Transaksi & Refund')

@section('content')
  <!-- Header -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Laporan & Analitik</h1>
      <nav class="flex mt-2 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-teal-600 font-medium">Laporan & Analitik</span>
      </nav>
    </div>

    <!-- Filter & Export -->
    <div class="mt-4 lg:mt-0 flex flex-wrap gap-2">
      <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
        </svg>
        Filter Periode
      </button>
      <button onclick="exportReport('pdf')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        Export PDF
      </button>
      <button onclick="exportReport('excel')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export Excel
      </button>
    </div>
  </div>

  <!-- Period Info -->
  <div class="bg-gradient-to-r from-teal-50 to-teal-100 border-l-4 border-teal-600 rounded-lg p-4 mb-6">
    <div class="flex items-center gap-3">
      <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
      <div class="flex-1">
        <p class="text-sm font-medium text-teal-900">Periode Laporan</p>
        <p class="text-xs text-teal-700">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
      </div>
      <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="text-sm text-teal-700 hover:text-teal-800 font-medium">
        Ubah Periode →
      </button>
    </div>
  </div>

  <!-- Summary Statistics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
      <div class="flex items-start justify-between mb-3">
        <div class="p-3 bg-blue-50 rounded-lg">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full font-medium">↑ 12%</span>
      </div>
      <p class="text-sm text-gray-600 mb-1">Total Penjualan</p>
      <p class="text-2xl font-bold text-gray-900">{{ $formattedSales }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
      <div class="flex items-start justify-between mb-3">
        <div class="p-3 bg-green-50 rounded-lg">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
          </svg>
        </div>
        <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full font-medium">↑ 8%</span>
      </div>
      <p class="text-sm text-gray-600 mb-1">Tiket Terjual</p>
      <p class="text-2xl font-bold text-gray-900">{{ number_format($salesStats['total_tickets']) }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
      <div class="flex items-start justify-between mb-3">
        <div class="p-3 bg-purple-50 rounded-lg">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
        </div>
        <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full font-medium">↑ 8%</span>
      </div>
      <p class="text-sm text-gray-600 mb-1">Total Penumpang</p>
      <p class="text-2xl font-bold text-gray-900">{{ number_format($salesStats['total_passengers']) }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
      <div class="flex items-start justify-between mb-3">
        <div class="p-3 bg-orange-50 rounded-lg">
          <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
          </svg>
        </div>
        <span class="text-xs px-2 py-1 bg-red-50 text-red-700 rounded-full font-medium">↓ 3%</span>
      </div>
      <p class="text-sm text-gray-600 mb-1">Rata-rata Transaksi</p>
      <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($salesStats['avg_transaction'], 0, ',', '.') }}</p>
    </div>
  </div>

  <!-- Tabs Navigation -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
    <div class="border-b border-gray-200">
      <nav class="flex -mb-px overflow-x-auto">
        <button onclick="switchTab('overview')" class="tab-btn active px-6 py-4 text-sm font-medium border-b-2 border-teal-600 text-teal-600 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
          Ringkasan
        </button>
        <button onclick="switchTab('sales')" class="tab-btn px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
          </svg>
          Penjualan Tiket
        </button>
        <button onclick="switchTab('routes')" class="tab-btn px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
          </svg>
          Rute & Penumpang
        </button>
        <button onclick="switchTab('revenue')" class="tab-btn px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          Pendapatan
        </button>
        <button onclick="switchTab('ships')" class="tab-btn px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
          </svg>
          Performa Kapal
        </button>
        <button onclick="switchTab('schedules')" class="tab-btn px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap">
          <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Analitik Jadwal
        </button>
      </nav>
    </div>

    <!-- Tab Content -->
    <div class="p-6">
      <!-- Tab 1: Overview (ENHANCED) -->
      <div id="tab-overview" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Penjualan Tiket Trend -->
          <div class="bg-gray-50 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">Tren Penjualan Tiket</h3>
                <p class="text-xs text-gray-500 mt-1">6 bulan terakhir • Klik untuk detail mingguan</p>
              </div>
              <button onclick="switchTab('sales')" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div id="salesChartOverview" style="height: 200px;"></div>
          </div>

          <!-- Rute Terpopuler -->
          <div class="bg-gray-50 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">Rute Terpopuler</h3>
                <p class="text-xs text-gray-500 mt-1">Total penumpang • Klik untuk breakdown kapal</p>
              </div>
              <button onclick="switchTab('routes')" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div id="routeChartOverview" style="height: 200px;"></div>
          </div>
        </div>

        <!-- Row 2: Metode Pembayaran & Top Kapal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Metode Pembayaran -->
          <div class="bg-gray-50 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">Metode Pembayaran</h3>
                <p class="text-xs text-gray-500 mt-1">Distribusi pembayaran tiket</p>
              </div>
              <button onclick="switchTab('revenue')" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div id="paymentChartOverview" style="height: 200px;"></div>
          </div>

          <!-- Top 5 Kapal -->
          <div class="bg-gray-50 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">Top 5 Kapal Terproduktif</h3>
                <p class="text-xs text-gray-500 mt-1">Berdasarkan pendapatan</p>
              </div>
              <button onclick="switchTab('ships')" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div id="topShipsChartOverview" style="height: 200px;"></div>
          </div>
        </div>

        <!-- Row 3: Jadwal Tersibuk & On-Time Performance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Jadwal Tersibuk -->
          <div class="bg-gray-50 rounded-lg p-5">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">Waktu Keberangkatan Favorit</h3>
                <p class="text-xs text-gray-500 mt-1">Jam dengan tiket terjual terbanyak</p>
              </div>
              <button onclick="switchTab('schedules')" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div id="scheduleTimeChartOverview" style="height: 200px;"></div>
          </div>

          <!-- On-Time Performance Widget -->
          <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg p-5 border border-teal-200">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-base font-semibold text-gray-800">On-Time Performance</h3>
                <p class="text-xs text-gray-600 mt-1">Ketepatan waktu keberangkatan</p>
              </div>
              <button onclick="switchTab('schedules')" class="text-sm text-teal-700 hover:text-teal-800 font-medium">
                Lihat Detail →
              </button>
            </div>
            <div class="flex items-center justify-center h-32">
              <div class="text-center">
                <div class="text-5xl font-bold text-teal-600 mb-2">87.5%</div>
                <p class="text-sm text-gray-700">Berangkat tepat waktu</p>
                <p class="text-xs text-gray-600 mt-1">245 dari 280 jadwal</p>
              </div>
            </div>
            <div class="mt-4 grid grid-cols-3 gap-3 text-center text-xs">
              <div class="bg-white/70 rounded-lg p-2">
                <p class="text-green-700 font-bold">245</p>
                <p class="text-gray-600">On Time</p>
              </div>
              <div class="bg-white/70 rounded-lg p-2">
                <p class="text-yellow-700 font-bold">28</p>
                <p class="text-gray-600">Terlambat</p>
              </div>
              <div class="bg-white/70 rounded-lg p-2">
                <p class="text-red-700 font-bold">7</p>
                <p class="text-gray-600">Batal</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 2: Penjualan Tiket (3 LEVEL DRILLDOWN) -->
      <div id="tab-sales" class="tab-content hidden">
        <div class="bg-gray-50 rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Analisa Penjualan Tiket</h3>
          <p class="text-sm text-gray-600 mb-6">
            <span class="font-medium">Level 1:</span> Klik bulan untuk lihat data mingguan •
            <span class="font-medium">Level 2:</span> Klik minggu untuk lihat data harian •
            <span class="font-medium">Level 3:</span> Detail per hari
          </p>
          <div id="salesChartFull" style="height: 450px;"></div>
        </div>
      </div>

      <!-- Tab 3: Rute & Penumpang -->
      <div id="tab-routes" class="tab-content hidden">
        <div class="bg-gray-50 rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Penumpang per Rute</h3>
          <p class="text-sm text-gray-600 mb-6">Klik pada bar untuk melihat detail kapal yang melayani rute tersebut. Data menunjukkan total penumpang yang terlayarkan.</p>
          <div id="routeChartFull" style="height: 450px;"></div>
        </div>
      </div>

      <!-- Tab 4: Pendapatan -->
      <div id="tab-revenue" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Metode Pembayaran</h3>
            <p class="text-sm text-gray-600 mb-6">Klik pada chart untuk melihat detail sub-kategori pembayaran.</p>
            <div id="revenueChart" style="height: 380px;"></div>
          </div>
          <div class="bg-white rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pendapatan</h3>
            <div class="space-y-4">
              <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-center gap-3">
                  <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                  <div>
                    <p class="text-sm font-medium text-gray-800">Tunai</p>
                    <p class="text-xs text-gray-500">Pembayaran di loket</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold text-gray-900">Rp 12.200.000</p>
                  <p class="text-xs text-gray-500">6.1%</p>
                </div>
              </div>
              <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-100">
                <div class="flex items-center gap-3">
                  <div class="w-3 h-3 rounded-full bg-green-500"></div>
                  <div>
                    <p class="text-sm font-medium text-gray-800">QRIS</p>
                    <p class="text-xs text-gray-500">Scan QRIS</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold text-gray-900">Rp 85.600.000</p>
                  <p class="text-xs text-gray-500">42.8%</p>
                </div>
              </div>
              <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg border border-orange-100">
                <div class="flex items-center gap-3">
                  <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                  <div>
                    <p class="text-sm font-medium text-gray-800">Transfer Bank</p>
                    <p class="text-xs text-gray-500">Transfer antar bank</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-sm font-bold text-gray-900">Rp 102.000.000</p>
                  <p class="text-xs text-gray-500">51.1%</p>
                </div>
              </div>
              <div class="border-t pt-4">
                <div class="flex items-center justify-between">
                  <p class="text-base font-semibold text-gray-800">Total Pendapatan</p>
                  <p class="text-xl font-bold text-teal-600">Rp 199.800.000</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 5: Performa Kapal (ENHANCED WITH CHARTS) -->
      <div id="tab-ships" class="tab-content hidden">
        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Revenue per Kapal -->
          <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan per Kapal</h3>
            <p class="text-sm text-gray-600 mb-4">Top 5 kapal dengan pendapatan tertinggi</p>
            <div id="shipRevenueChart" style="height: 300px;"></div>
          </div>

          <!-- Occupancy Rate -->
          <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tingkat Hunian Kapal</h3>
            <p class="text-sm text-gray-600 mb-4">Persentase kapasitas terisi</p>
            <div id="occupancyChart" style="height: 300px;"></div>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200">
          <div class="p-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Detail Performa Kapal</h3>
            <p class="text-sm text-gray-600 mt-1">Data pendapatan dan operasional kapal dalam periode yang dipilih</p>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kapal</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rute Utama</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Jadwal Aktif</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tiket Terjual</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tingkat Hunian</th>
                  <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendapatan</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($shipRevenue as $ship)
                  <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-teal-100 rounded-lg flex items-center justify-center">
                          <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                          </svg>
                        </div>
                        <div class="ml-4">
                          <p class="text-sm font-semibold text-gray-900">{{ $ship['ship_name'] }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="text-sm text-gray-700">{{ $ship['route'] }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                        {{ $ship['active_schedules'] }} jadwal
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      <span class="text-sm font-medium text-gray-900">{{ number_format($ship['total_tickets']) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                      <div class="flex items-center justify-center gap-2">
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                          <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $ship['occupancy_rate'] ?? 75 }}%"></div>
                        </div>
                        <span class="text-xs font-medium text-gray-700">{{ $ship['occupancy_rate'] ?? 75 }}%</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                      <span class="text-sm font-bold text-gray-900">Rp {{ number_format($ship['revenue'], 0, ',', '.') }}</span>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                      <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                      </svg>
                      <p class="text-gray-500 font-medium">Tidak ada data performa kapal</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Tab 6: Analitik Jadwal (NEW) -->
      <div id="tab-schedules" class="tab-content hidden">
        <!-- Top Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-5 border border-green-200">
            <div class="flex items-center gap-3 mb-3">
              <div class="p-2 bg-green-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              <p class="text-sm font-medium text-gray-700">Tepat Waktu</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">87.5%</p>
            <p class="text-xs text-gray-600 mt-1">245 dari 280 jadwal</p>
          </div>

          <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-5 border border-yellow-200">
            <div class="flex items-center gap-3 mb-3">
              <div class="p-2 bg-yellow-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <p class="text-sm font-medium text-gray-700">Terlambat</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">10%</p>
            <p class="text-xs text-gray-600 mt-1">28 jadwal (avg. 15 menit)</p>
          </div>

          <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-5 border border-red-200">
            <div class="flex items-center gap-3 mb-3">
              <div class="p-2 bg-red-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <p class="text-sm font-medium text-gray-700">Dibatalkan</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">2.5%</p>
            <p class="text-xs text-gray-600 mt-1">7 jadwal (cuaca buruk)</p>
          </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Jadwal Terlaris -->
          <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Terlaris</h3>
            <p class="text-sm text-gray-600 mb-4">Berdasarkan jumlah tiket terjual</p>
            <div id="topSchedulesChart" style="height: 350px;"></div>
          </div>

          <!-- Jam Keberangkatan Favorit -->
          <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Jam Keberangkatan Favorit</h3>
            <p class="text-sm text-gray-600 mb-4">Distribusi penumpang per waktu keberangkatan</p>
            <div id="departureTimeChart" style="height: 350px;"></div>
          </div>
        </div>

        <!-- On-Time Performance Detail Table -->
        <div class="bg-white rounded-lg border border-gray-200">
          <div class="p-5 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Detail Keterlambatan</h3>
            <p class="text-sm text-gray-600 mt-1">Riwayat jadwal yang mengalami keterlambatan</p>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kapal</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rute</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Jadwal</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Berangkat</th>
                  <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Keterlambatan</th>
                  <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Alasan</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-900">28 Okt 2025</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">KM Bahari</td>
                  <td class="px-6 py-4 text-sm text-gray-700">Muara - Surabaya</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">08:00</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">08:25</td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                      25 menit
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">Antrian boarding penumpang</td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-900">27 Okt 2025</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">KM Lambelu</td>
                  <td class="px-6 py-4 text-sm text-gray-700">Ketapang - Gilimanuk</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">14:30</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">14:45</td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                      15 menit
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">Pengecekan teknis mesin</td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-900">26 Okt 2025</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">KM Express</td>
                  <td class="px-6 py-4 text-sm text-gray-700">Jakarta - Batam</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">06:00</td>
                  <td class="px-6 py-4 text-sm text-center text-red-600 font-medium">Batal</td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                      Batal
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">Cuaca buruk (gelombang tinggi)</td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-900">25 Okt 2025</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">KM Nusantara</td>
                  <td class="px-6 py-4 text-sm text-gray-700">Muara - Surabaya</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">10:00</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">10:10</td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                      10 menit
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">Koordinasi antar kapal di pelabuhan</td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-900">24 Okt 2025</td>
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">KM Mariana</td>
                  <td class="px-6 py-4 text-sm text-gray-700">Ujung - Kamal</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">16:00</td>
                  <td class="px-6 py-4 text-sm text-center text-gray-900">16:20</td>
                  <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                      20 menit
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">Arus lalu lintas pelabuhan padat</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div id="filterModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Filter Periode Laporan</h3>
          <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
      <form method="GET" action="{{ route('admin.reports.index') }}" class="p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
          <input
            type="date"
            name="start_date"
            value="{{ $startDate }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
          >
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
          <input
            type="date"
            name="end_date"
            value="{{ $endDate }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
          >
        </div>
        <div class="flex gap-3 pt-4">
          <button type="submit" class="flex-1 px-4 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-medium transition">
            Terapkan Filter
          </button>
          <a href="{{ route('admin.reports.index') }}" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition">
            Reset
          </a>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
  <!-- Highcharts Library -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/drilldown.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>

  <script>
    // Global Highcharts Options
    Highcharts.setOptions({
      lang: {
        drillUpText: '← Kembali',
        thousandsSep: '.'
      },
      credits: {
        enabled: false
      }
    });

    // Common Chart Config
    const commonConfig = {
      chart: {
        backgroundColor: 'transparent',
        style: {
          fontFamily: 'system-ui, -apple-system, sans-serif'
        }
      },
      xAxis: {
        type: 'category',
        labels: {
          style: {
            fontSize: '11px',
            fontWeight: '500',
            color: '#64748b'
          }
        },
        lineWidth: 0,
        tickLength: 0
      },
      yAxis: {
        gridLineColor: '#e2e8f0',
        labels: {
          style: {
            fontSize: '11px',
            color: '#64748b'
          }
        }
      },
      legend: {
        enabled: false
      },
      tooltip: {
        backgroundColor: '#1e293b',
        borderWidth: 0,
        borderRadius: 8,
        shadow: true,
        style: {
          color: '#ffffff',
          fontSize: '12px'
        }
      },
      plotOptions: {
        series: {
          borderWidth: 0,
          borderRadius: 6,
          dataLabels: {
            enabled: true,
            style: {
              fontSize: '11px',
              fontWeight: 'bold',
              color: '#1e293b',
              textOutline: 'none'
            }
          },
          cursor: 'pointer',
          states: {
            hover: {
              brightness: 0.1
            }
          }
        }
      },
      drilldown: {
        breadcrumbs: {
          position: {
            align: 'right'
          },
          buttonTheme: {
            fill: '#0f766e',
            style: {
              color: '#ffffff',
              fontSize: '11px'
            },
            states: {
              hover: {
                fill: '#115e59'
              }
            }
          }
        }
      }
    };

    //  DATA DEFINITIONS

    // Sales Data with 3-Level Drilldown (Monthly -> Weekly -> Daily)
    const salesData = {
      series: [{
        name: 'Penjualan',
        colorByPoint: true,
        colors: ['#0f766e', '#14b8a6', '#2dd4bf', '#5eead4', '#99f6e4', '#ccfbf1'],
        data: [
          { name: 'Januari', y: 450, drilldown: 'januari' },
          { name: 'Februari', y: 380, drilldown: 'februari' },
          { name: 'Maret', y: 520, drilldown: 'maret' },
          { name: 'April', y: 410, drilldown: 'april' },
          { name: 'Mei', y: 490, drilldown: 'mei' },
          { name: 'Juni', y: 550, drilldown: 'juni' }
        ]
      }],
      drilldown: [
        // Level 2: Weekly data for each month
        {
          name: 'Januari',
          id: 'januari',
          data: [
            ['Minggu 1', 120, 'januari-w1'],
            ['Minggu 2', 110, 'januari-w2'],
            ['Minggu 3', 105, 'januari-w3'],
            ['Minggu 4', 115, 'januari-w4']
          ],
          color: '#0f766e'
        },
        {
          name: 'Februari',
          id: 'februari',
          data: [
            ['Minggu 1', 95, 'februari-w1'],
            ['Minggu 2', 100, 'februari-w2'],
            ['Minggu 3', 90, 'februari-w3'],
            ['Minggu 4', 95, 'februari-w4']
          ],
          color: '#14b8a6'
        },
        {
          name: 'Maret',
          id: 'maret',
          data: [
            ['Minggu 1', 135, 'maret-w1'],
            ['Minggu 2', 130, 'maret-w2'],
            ['Minggu 3', 125, 'maret-w3'],
            ['Minggu 4', 130, 'maret-w4']
          ],
          color: '#2dd4bf'
        },
        {
          name: 'April',
          id: 'april',
          data: [
            ['Minggu 1', 105, 'april-w1'],
            ['Minggu 2', 100, 'april-w2'],
            ['Minggu 3', 102, 'april-w3'],
            ['Minggu 4', 103, 'april-w4']
          ],
          color: '#5eead4'
        },
        {
          name: 'Mei',
          id: 'mei',
          data: [
            ['Minggu 1', 125, 'mei-w1'],
            ['Minggu 2', 120, 'mei-w2'],
            ['Minggu 3', 122, 'mei-w3'],
            ['Minggu 4', 123, 'mei-w4']
          ],
          color: '#99f6e4'
        },
        {
          name: 'Juni',
          id: 'juni',
          data: [
            ['Minggu 1', 140, 'juni-w1'],
            ['Minggu 2', 135, 'juni-w2'],
            ['Minggu 3', 137, 'juni-w3'],
            ['Minggu 4', 138, 'juni-w4']
          ],
          color: '#ccfbf1'
        },

        // Level 3: Daily data for each week (example for Januari)
        { name: 'Januari - Minggu 1', id: 'januari-w1', data: [['Sen', 18], ['Sel', 17], ['Rab', 16], ['Kam', 20], ['Jum', 19], ['Sab', 15], ['Min', 15]], color: '#0f766e' },
        { name: 'Januari - Minggu 2', id: 'januari-w2', data: [['Sen', 16], ['Sel', 15], ['Rab', 17], ['Kam', 16], ['Jum', 18], ['Sab', 14], ['Min', 14]], color: '#0f766e' },
        { name: 'Januari - Minggu 3', id: 'januari-w3', data: [['Sen', 15], ['Sel', 14], ['Rab', 16], ['Kam', 15], ['Jum', 17], ['Sab', 14], ['Min', 14]], color: '#0f766e' },
        { name: 'Januari - Minggu 4', id: 'januari-w4', data: [['Sen', 17], ['Sel', 16], ['Rab', 18], ['Kam', 16], ['Jum', 19], ['Sab', 15], ['Min', 14]], color: '#0f766e' },

        // Daily data for Februari weeks
        { name: 'Februari - Minggu 1', id: 'februari-w1', data: [['Sen', 14], ['Sel', 13], ['Rab', 15], ['Kam', 14], ['Jum', 16], ['Sab', 12], ['Min', 11]], color: '#14b8a6' },
        { name: 'Februari - Minggu 2', id: 'februari-w2', data: [['Sen', 15], ['Sel', 14], ['Rab', 16], ['Kam', 15], ['Jum', 17], ['Sab', 12], ['Min', 11]], color: '#14b8a6' },
        { name: 'Februari - Minggu 3', id: 'februari-w3', data: [['Sen', 13], ['Sel', 12], ['Rab', 14], ['Kam', 14], ['Jum', 15], ['Sab', 11], ['Min', 11]], color: '#14b8a6' },
        { name: 'Februari - Minggu 4', id: 'februari-w4', data: [['Sen', 14], ['Sel', 13], ['Rab', 15], ['Kam', 14], ['Jum', 16], ['Sab', 12], ['Min', 11]], color: '#14b8a6' },

        // Daily data for Maret weeks
        { name: 'Maret - Minggu 1', id: 'maret-w1', data: [['Sen', 20], ['Sel', 19], ['Rab', 21], ['Kam', 20], ['Jum', 22], ['Sab', 17], ['Min', 16]], color: '#2dd4bf' },
        { name: 'Maret - Minggu 2', id: 'maret-w2', data: [['Sen', 19], ['Sel', 18], ['Rab', 20], ['Kam', 19], ['Jum', 21], ['Sab', 17], ['Min', 16]], color: '#2dd4bf' },
        { name: 'Maret - Minggu 3', id: 'maret-w3', data: [['Sen', 18], ['Sel', 17], ['Rab', 19], ['Kam', 18], ['Jum', 20], ['Sab', 17], ['Min', 16]], color: '#2dd4bf' },
        { name: 'Maret - Minggu 4', id: 'maret-w4', data: [['Sen', 19], ['Sel', 18], ['Rab', 20], ['Kam', 19], ['Jum', 21], ['Sab', 17], ['Min', 16]], color: '#2dd4bf' },

        // Daily data for April weeks
        { name: 'April - Minggu 1', id: 'april-w1', data: [['Sen', 15], ['Sel', 15], ['Rab', 16], ['Kam', 15], ['Jum', 17], ['Sab', 14], ['Min', 13]], color: '#5eead4' },
        { name: 'April - Minggu 2', id: 'april-w2', data: [['Sen', 14], ['Sel', 14], ['Rab', 15], ['Kam', 15], ['Jum', 16], ['Sab', 13], ['Min', 13]], color: '#5eead4' },
        { name: 'April - Minggu 3', id: 'april-w3', data: [['Sen', 15], ['Sel', 14], ['Rab', 16], ['Kam', 15], ['Jum', 17], ['Sab', 13], ['Min', 12]], color: '#5eead4' },
        { name: 'April - Minggu 4', id: 'april-w4', data: [['Sen', 15], ['Sel', 15], ['Rab', 16], ['Kam', 15], ['Jum', 17], ['Sab', 13], ['Min', 12]], color: '#5eead4' },

        // Daily data for Mei weeks
        { name: 'Mei - Minggu 1', id: 'mei-w1', data: [['Sen', 18], ['Sel', 18], ['Rab', 19], ['Kam', 18], ['Jum', 20], ['Sab', 16], ['Min', 16]], color: '#99f6e4' },
        { name: 'Mei - Minggu 2', id: 'mei-w2', data: [['Sen', 17], ['Sel', 17], ['Rab', 18], ['Kam', 18], ['Jum', 19], ['Sab', 16], ['Min', 15]], color: '#99f6e4' },
        { name: 'Mei - Minggu 3', id: 'mei-w3', data: [['Sen', 18], ['Sel', 17], ['Rab', 19], ['Kam', 18], ['Jum', 20], ['Sab', 15], ['Min', 15]], color: '#99f6e4' },
        { name: 'Mei - Minggu 4', id: 'mei-w4', data: [['Sen', 18], ['Sel', 18], ['Rab', 19], ['Kam', 18], ['Jum', 20], ['Sab', 15], ['Min', 15]], color: '#99f6e4' },

        // Daily data for Juni weeks
        { name: 'Juni - Minggu 1', id: 'juni-w1', data: [['Sen', 20], ['Sel', 20], ['Rab', 21], ['Kam', 20], ['Jum', 22], ['Sab', 19], ['Min', 18]], color: '#ccfbf1' },
        { name: 'Juni - Minggu 2', id: 'juni-w2', data: [['Sen', 19], ['Sel', 19], ['Rab', 20], ['Kam', 20], ['Jum', 21], ['Sab', 18], ['Min', 18]], color: '#ccfbf1' },
        { name: 'Juni - Minggu 3', id: 'juni-w3', data: [['Sen', 20], ['Sel', 19], ['Rab', 21], ['Kam', 20], ['Jum', 22], ['Sab', 18], ['Min', 17]], color: '#ccfbf1' },
        { name: 'Juni - Minggu 4', id: 'juni-w4', data: [['Sen', 20], ['Sel', 20], ['Rab', 21], ['Kam', 20], ['Jum', 22], ['Sab', 18], ['Min', 17]], color: '#ccfbf1' }
      ]
    };

    // Route Data
    const routeData = {
      series: [{
        name: 'Rute',
        colorByPoint: true,
        colors: ['#3b82f6', '#10b981', '#f59e0b', '#f43f5e'],
        data: [
          { name: 'Muara - Surabaya', y: 745, drilldown: 'muara-surabaya' },
          { name: 'Ketapang - Banyuwangi', y: 543, drilldown: 'ketapang-banyuwangi' },
          { name: 'Jakarta - Batam', y: 412, drilldown: 'jakarta-batam' },
          { name: 'Jakarta - Ambon', y: 324, drilldown: 'jakarta-ambon' }
        ]
      }],
      drilldown: [
        { name: 'Muara - Surabaya', id: 'muara-surabaya', data: [['KM Nusantara', 320], ['KM Bahari', 280], ['KM Lambelu', 145]], color: '#3b82f6' },
        { name: 'Ketapang - Banyuwangi', id: 'ketapang-banyuwangi', data: [['KM Express', 250], ['KM Pelni', 193], ['KM Jaya', 100]], color: '#10b981' },
        { name: 'Jakarta - Batam', id: 'jakarta-batam', data: [['KM Lautan', 220], ['KM Nusantara', 120], ['KM Cepat', 72]], color: '#f59e0b' },
        { name: 'Jakarta - Ambon', id: 'jakarta-ambon', data: [['KM Pelni', 180], ['KM Express', 94], ['KM Samudra', 50]], color: '#f43f5e' }
      ]
    };

    //  CHART INITIALIZATION FUNCTIONS

    function initCharts() {
      // Overview Charts (smaller)
      Highcharts.chart('salesChartOverview', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'column', height: 200 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Tiket: <b>{point.y}</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          column: { pointPadding: 0.1, groupPadding: 0.15 },
          series: { ...commonConfig.plotOptions.series, dataLabels: { enabled: false } }
        },
        series: salesData.series,
        drilldown: { ...commonConfig.drilldown, series: salesData.drilldown }
      });

      Highcharts.chart('routeChartOverview', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'bar', height: 200 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Penumpang: <b>{point.y}</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          bar: { pointPadding: 0.1, groupPadding: 0.15 },
          series: { ...commonConfig.plotOptions.series, dataLabels: { enabled: false } }
        },
        series: routeData.series,
        drilldown: { ...commonConfig.drilldown, series: routeData.drilldown }
      });

      // Payment Method Chart (Overview)
      Highcharts.chart('paymentChartOverview', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'pie', height: 200 },
        title: { text: null },
        plotOptions: {
          pie: {
            innerSize: '50%',
            dataLabels: {
              enabled: true,
              format: '{point.percentage:.1f}%',
              distance: -30,
              style: { fontSize: '10px', fontWeight: 'bold', textOutline: 'none', color: '#ffffff' }
            }
          }
        },
        tooltip: { ...commonConfig.tooltip, pointFormat: '<b>Rp {point.y:,.0f}</b>' },
        series: [{
          name: 'Metode',
          colorByPoint: true,
          data: [
            { name: 'Transfer', y: 102000000, color: '#f59e0b' },
            { name: 'QRIS', y: 85600000, color: '#10b981' },
            { name: 'Tunai', y: 12200000, color: '#3b82f6' }
          ]
        }]
      });

      // Top Ships Chart (Overview)
      Highcharts.chart('topShipsChartOverview', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'bar', height: 200 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: '<b>Rp {point.y:,.0f}</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          bar: { pointPadding: 0.1, groupPadding: 0.15 },
          series: { ...commonConfig.plotOptions.series, dataLabels: { enabled: false } }
        },
        series: [{
          name: 'Pendapatan',
          colorByPoint: true,
          colors: ['#0f766e', '#14b8a6', '#2dd4bf', '#5eead4', '#99f6e4'],
          data: [
            ['KM Bahari', 1300000000],
            ['KM Lambelu', 1100000000],
            ['KM Mariana', 580000000],
            ['KM Teluk Indah', 360000000],
            ['KM MTB Express', 280000000]
          ]
        }]
      });

      // Schedule Time Chart (Overview)
      Highcharts.chart('scheduleTimeChartOverview', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'column', height: 200 },
        title: { text: null },
        xAxis: { ...commonConfig.xAxis, categories: ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00'] },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Tiket: <b>{point.y}</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          column: { pointPadding: 0.1, groupPadding: 0.15, color: '#0f766e' },
          series: { ...commonConfig.plotOptions.series, dataLabels: { enabled: false } }
        },
        series: [{
          name: 'Tiket Terjual',
          data: [180, 320, 280, 210, 290, 350, 240]
        }]
      });

      // Full Sales Chart with 3-level drilldown
      Highcharts.chart('salesChartFull', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'column', height: 450 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: 'Jumlah Tiket', style: { fontSize: '12px', color: '#64748b' } } },
        tooltip: { ...commonConfig.tooltip, headerFormat: '<b style="font-size:13px">{point.key}</b><br/>', pointFormat: 'Tiket terjual: <b>{point.y}</b>' },
        plotOptions: { ...commonConfig.plotOptions, column: { pointPadding: 0.1, groupPadding: 0.15 } },
        series: salesData.series,
        drilldown: { ...commonConfig.drilldown, series: salesData.drilldown }
      });

      // Full Route Chart
      Highcharts.chart('routeChartFull', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'bar', height: 450 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: 'Jumlah Penumpang', style: { fontSize: '12px', color: '#64748b' } } },
        tooltip: { ...commonConfig.tooltip, headerFormat: '<b style="font-size:13px">{point.key}</b><br/>', pointFormat: 'Penumpang: <b>{point.y}</b>' },
        plotOptions: { ...commonConfig.plotOptions, bar: { pointPadding: 0.1, groupPadding: 0.15 } },
        series: routeData.series,
        drilldown: { ...commonConfig.drilldown, series: routeData.drilldown }
      });

      // Revenue Pie Chart
      Highcharts.chart('revenueChart', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'pie', height: 380 },
        title: { text: null },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            innerSize: '55%',
            dataLabels: {
              enabled: true,
              format: '<b>{point.name}</b><br>{point.percentage:.1f}%',
              distance: 15,
              style: { fontSize: '11px', fontWeight: 'bold', textOutline: 'none' }
            },
            showInLegend: false
          }
        },
        tooltip: { ...commonConfig.tooltip, pointFormat: '<b>Rp {point.y:,.0f}</b> ({point.percentage:.1f}%)' },
        series: [{
          name: 'Pendapatan',
          colorByPoint: true,
          data: [
            { name: 'Tunai', y: 12200000, drilldown: 'tunai', color: '#3b82f6' },
            { name: 'QRIS', y: 85600000, drilldown: 'qris', color: '#10b981' },
            { name: 'Transfer Bank', y: 102000000, drilldown: 'transfer', color: '#f59e0b' }
          ]
        }],
        drilldown: {
          ...commonConfig.drilldown,
          series: [
            { name: 'Tunai - Detail', id: 'tunai', data: [['Loket Surabaya', 6000000], ['Loket Bali', 4200000], ['Loket Jakarta', 2000000]] },
            { name: 'QRIS - Detail', id: 'qris', data: [['GoPay', 40000000], ['OVO', 25000000], ['Dana', 15000000], ['ShopeePay', 5600000]] },
            { name: 'Transfer Bank - Detail', id: 'transfer', data: [['BCA', 45000000], ['Mandiri', 30000000], ['BNI', 17000000], ['BRI', 10000000]] }
          ]
        }
      });

      // Ship Revenue Chart
      Highcharts.chart('shipRevenueChart', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'bar', height: 300 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: '<b>Rp {point.y:,.0f}</b>' },
        plotOptions: { ...commonConfig.plotOptions, bar: { pointPadding: 0.1, groupPadding: 0.15 } },
        series: [{
          name: 'Pendapatan',
          colorByPoint: true,
          colors: ['#0f766e', '#14b8a6', '#2dd4bf', '#5eead4', '#99f6e4'],
          data: [
            ['KM Bahari', 1300000000],
            ['KM Lambelu', 1100000000],
            ['KM Mariana', 580000000],
            ['KM Teluk Indah', 360000000],
            ['KM MTB Express', 280000000]
          ]
        }]
      });

      // Occupancy Rate Chart
      Highcharts.chart('occupancyChart', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'column', height: 300 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null }, max: 100, labels: { format: '{value}%' } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Tingkat Hunian: <b>{point.y}%</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          column: { pointPadding: 0.1, groupPadding: 0.15 },
          series: {
            ...commonConfig.plotOptions.series,
            dataLabels: { ...commonConfig.plotOptions.series.dataLabels, format: '{point.y}%' }
          }
        },
        series: [{
          name: 'Occupancy',
          colorByPoint: true,
          colors: ['#10b981', '#10b981', '#f59e0b', '#f59e0b', '#ef4444'],
          data: [
            ['KM Bahari', 85],
            ['KM Lambelu', 78],
            ['KM Mariana', 72],
            ['KM Teluk Indah', 68],
            ['KM MTB Express', 62]
          ]
        }]
      });

      // Top Schedules Chart
      Highcharts.chart('topSchedulesChart', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'bar', height: 350 },
        title: { text: null },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Tiket Terjual: <b>{point.y}</b>' },
        plotOptions: { ...commonConfig.plotOptions, bar: { pointPadding: 0.1, groupPadding: 0.15 } },
        series: [{
          name: 'Tiket',
          colorByPoint: true,
          colors: ['#0f766e', '#14b8a6', '#2dd4bf', '#5eead4', '#99f6e4', '#ccfbf1'],
          data: [
            ['KM Bahari 08:00', 450],
            ['KM Lambelu 10:00', 420],
            ['KM Nusantara 06:00', 380],
            ['KM Express 14:00', 350],
            ['KM Mariana 16:00', 320],
            ['KM Pelni 12:00', 290]
          ]
        }]
      });

      // Departure Time Distribution
      Highcharts.chart('departureTimeChart', {
        ...commonConfig,
        chart: { ...commonConfig.chart, type: 'column', height: 350 },
        title: { text: null },
        xAxis: { ...commonConfig.xAxis, categories: ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'] },
        yAxis: { ...commonConfig.yAxis, title: { text: null } },
        tooltip: { ...commonConfig.tooltip, pointFormat: 'Total Penumpang: <b>{point.y}</b>' },
        plotOptions: {
          ...commonConfig.plotOptions,
          column: {
            pointPadding: 0.1,
            groupPadding: 0.15,
            zones: [
              { value: 300, color: '#ef4444' },
              { value: 400, color: '#f59e0b' },
              { color: '#10b981' }
            ]
          }
        },
        series: [{
          name: 'Penumpang',
          data: [280, 520, 480, 350, 450, 580, 420, 320]
        }]
      });
    }

    // Tab Switching
    function switchTab(tabName) {
      document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'border-teal-600', 'text-teal-600');
        btn.classList.add('border-transparent', 'text-gray-600');
      });

      document.getElementById(`tab-${tabName}`).classList.remove('hidden');
      event.target.closest('.tab-btn').classList.add('active', 'border-teal-600', 'text-teal-600');
      event.target.closest('.tab-btn').classList.remove('border-transparent', 'text-gray-600');
    }

    // Export Function
    function exportReport(type) {
      const startDate = '{{ $startDate }}';
      const endDate = '{{ $endDate }}';
      alert(`Export ${type.toUpperCase()} akan segera tersedia!\nPeriode: ${startDate} - ${endDate}`);
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
      initCharts();
    });
  </script>
  @endpush
@endsection
