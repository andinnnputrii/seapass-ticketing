@extends('layouts.app')

@section('content')
<div class="container-fluid px-6 py-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">

        {{-- Judul + Breadcrumb --}}
        <div>
        <h2 class="text-2xl font-semibold text-slate-800 mb-1">Tiket Validasi</h2>
        <nav class="flex items-center text-sm text-teal-600">
            <span>Tiket Validasi</span>
            <span class="mx-2">></span>
            <span class="font-semibold">
                @if($activeTab == 'tiket') Tiket Pemesanan
                @elseif($activeTab == 'kendaraan') Kendaraan
                @else Validasi Tiket
                @endif
            </span>
        </nav>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-5 gap-4 mb-6">
        <!-- Total Penumpang -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 mb-1">Total Penumpang</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalPenumpang) }}</h3>
                    <p class="text-xs mt-1">
                        <span class="text-red-500">↓ 1.2%</span>
                        <span class="text-gray-500 ml-1">Saat Ini</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tiket Terjual -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 mb-1">Tiket Terjual</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($tiketTerjual) }}</h3>
                    <p class="text-xs mt-1">
                        <span class="text-green-500">↑ 2.3%</span>
                        <span class="text-gray-500 ml-1">Saat Ini</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tervalidasi -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <h3 class="text-4xl font-bold text-green-500 mb-1">{{ number_format($tervalidasi) }}</h3>
                <p class="text-sm text-gray-600">Tervalidasi</p>
            </div>
        </div>

        <!-- Pending / Batal -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <h3 class="text-4xl font-bold text-red-500 mb-1">{{ number_format($pendingBatal) }}</h3>
                <p class="text-sm text-gray-600">Pending / Batal</p>
            </div>
        </div>

        <!-- Reschedule -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <h3 class="text-4xl font-bold text-yellow-500 mb-1">{{ number_format($reschedule) }}</h3>
                <p class="text-sm text-gray-600">Reschedule</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4 flex items-center gap-4">
        <button class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filter
        </button>

        <form method="GET" action="{{ route('tiket-validasi.index') }}" class="relative flex-1 max-w-xs">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari"
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg border border-gray-200 mb-4">
        <div class="border-b border-gray-200 px-4">
            <nav class="flex -mb-px">
                <a href="{{ route('tiket-validasi.index', ['tab' => 'tiket']) }}"
                   class="flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab == 'tiket' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    Tiket Pemesanan
                </a>
                <a href="{{ route('tiket-validasi.index', ['tab' => 'kendaraan']) }}"
                   class="flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab == 'kendaraan' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    Kendaraan
                </a>
                <a href="{{ route('tiket-validasi.index', ['tab' => 'validasi']) }}"
                   class="flex items-center gap-2 px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab == 'validasi' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Validasi Tiket
                </a>
            </nav>
        </div>



        <!-- Table Content -->
        <div class="overflow-x-auto">
            @if($activeTab == 'tiket')
                <!-- TAB TIKET PEMESANAN -->
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Jadwal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tipe Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Metode Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tikets ?? [] as $tiket)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $tiket->tiket_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $tiket->penumpang_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">JDW{{ str_pad($tiket->jadwal_id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $tiket->tipe_tiket }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    {{ $tiket->status_tiket == 'Valid' ? 'bg-green-100 text-green-700' :
                                       ($tiket->status_tiket == 'Batal' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $tiket->status_tiket }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $tiket->metode_bayar }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p>Tidak ada data tiket</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(isset($tikets) && $tikets->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-center items-center gap-3">
                        {{-- Previous --}}
                        @if ($tikets->onFirstPage())
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                ← Previous
                            </button>
                        @else
                            <a href="{{ $tikets->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                ← Previous
                            </a>
                        @endif

                        {{-- Numbers --}}
                        <div class="flex gap-2">
                            @foreach ($tikets->getUrlRange(1, $tikets->lastPage()) as $page => $url)
                                @if ($page == $tikets->currentPage())
                                    <button class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-teal-600 rounded-lg">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next --}}
                        @if ($tikets->hasMorePages())
                            <a href="{{ $tikets->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                Next →
                            </a>
                        @else
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                Next →
                            </button>
                        @endif
                    </div>
                </div>
                @endif

            @elseif($activeTab == 'kendaraan')
                <!-- TAB KENDARAAN -->
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jenis Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Panjang (m)</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Muatan (kg)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kendaraans ?? [] as $kendaraan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $kendaraan->kendaraan_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $kendaraan->tiket_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $kendaraan->plat_nomor }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $kendaraan->jenis_kendaraan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($kendaraan->panjang, 1) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($kendaraan->muatan) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h4a1 1 0 001-1m-6 0H9"/>
                                </svg>
                                <p>Tidak ada data kendaraan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(isset($kendaraans) && $kendaraans->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-center items-center gap-3">
                        {{-- Previous --}}
                        @if ($kendaraans->onFirstPage())
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                ← Previous
                            </button>
                        @else
                            <a href="{{ $tikets->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                ← Previous
                            </a>
                        @endif

                        {{-- Numbers --}}
                        <div class="flex gap-2">
                            @foreach ($kendaraans->getUrlRange(1, $kendaraans->lastPage()) as $page => $url)
                                @if ($page == $kendaraans->currentPage())
                                    <button class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-teal-600 rounded-lg">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next --}}
                        @if ($kendaraans->hasMorePages())
                            <a href="{{ $kendaraans->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                Next →
                            </a>
                        @else
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                Next →
                            </button>
                        @endif
                    </div>
                </div>
                @endif

            @elseif($activeTab == 'validasi')
                <!-- TAB VALIDASI TIKET -->
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Log</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status Validasi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Lokasi Pintu</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Petugas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($validasis ?? [] as $validasi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->tiket_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->waktu_validasi->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    {{ $validasi->status_validasi == 'valid' ? 'bg-green-100 text-green-700' :
                                       ($validasi->status_validasi == 'invalid' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $validasi->status_validasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->metode }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->lokasi_pintu }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $validasi->petugas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $validasi->catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p>Tidak ada data validasi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(isset($validasis) && $validasis->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-center items-center gap-3">
                        {{-- Previous --}}
                        @if ($validasis->onFirstPage())
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                ← Previous
                            </button>
                        @else
                            <a href="{{ $tikets->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                ← Previous
                            </a>
                        @endif

                        {{-- Numbers --}}
                        <div class="flex gap-2">
                            @foreach ($validasis->getUrlRange(1, $validasis->lastPage()) as $page => $url)
                                @if ($page == $validasis->currentPage())
                                    <button class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-teal-600 rounded-lg">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next --}}
                        @if ($validasis->hasMorePages())
                            <a href="{{ $validasis->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                                Next →
                            </a>
                        @else
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                                Next →
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
