@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header & Breadcrumb -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Jadwal Kapal</h1>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i data-feather="x" class="w-4 h-4"></i>
        </button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Kapal Berlayar -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 2v15"/><path d="M7 22a4 4 0 0 1-4-4 1 1 0 0 1 1-1h16a1 1 0 0 1 1 1 4 4 0 0 1-4 4z"/><path d="M9.159 2.46a1 1 0 0 1 1.521-.193l9.977 8.98A1 1 0 0 1 20 13H4a1 1 0 0 1-.824-1.567z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900">{{ $totalKapalBerlayar }}</div>
                    <div class="text-xs text-slate-600">Total Kapal Berlayar</div>
                </div>
            </div>
        </div>

        <!-- Total Kapal Cadangan -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="8"/><path d="M12 2v7.5"/><path d="m19 5-5.23 5.23"/><path d="M22 12h-7.5"/><path d="m19 19-5.23-5.23"/><path d="M12 14.5V22"/><path d="M10.23 13.77 5 19"/><path d="M9.5 12H2"/><path d="M10.23 10.23 5 5"/><circle cx="12" cy="12" r="2.5"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900">{{ $totalKapalCadangan }}</div>
                    <div class="text-xs text-slate-600">Total Kapal Cadangan</div>
                </div>
            </div>
        </div>

        <!-- Total Waktu -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 6v6l3.644 1.822"/><path d="M16 19h6"/><path d="M19 16v6"/><path d="M21.92 13.267a10 10 0 1 0-8.653 8.653"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900">{{ $totalWaktu }}</div>
                    <div class="text-xs text-slate-600">Total Waktu</div>
                </div>
            </div>
        </div>

        <!-- Penerbitan Berlayar -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i data-feather="file-text" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900">{{ $penerbitan }}</div>
                    <div class="text-xs text-slate-600">Penerbitan Berlayar</div>
                </div>
            </div>
        </div>

        <!-- Pembatalan Berlayar -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900">{{ $pembatalan }}</div>
                    <div class="text-xs text-slate-600">Pembatalan Berlayar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section - FIXED RESPONSIVE -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
        <div class="flex flex-col lg:flex-row gap-4 lg:items-center">
            <!-- Left: Filter Form -->
            <form method="GET" action="{{ route('jadwal-kapal.index') }}" class="flex flex-wrap gap-3 items-center">
                <!-- Filter Status -->
                <select name="status" class="h-[42px] border border-gray-300 rounded-lg px-4 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">Status</option>
                    <option value="On-Time" {{ request('status') == 'On-Time' ? 'selected' : '' }}>Tepat Waktu</option>
                    <option value="Delay" {{ request('status') == 'Delay' ? 'selected' : '' }}>Terlambat</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Backup" {{ request('status') == 'Backup' ? 'selected' : '' }}>Cadangan</option>
                </select>

                <!-- Filter Pelabuhan Asal -->
                <select name="pelabuhan_asal" class="h-[42px] border border-gray-300 rounded-lg px-4 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">Pelabuhan Asal</option>
                    <option value="Tanjung Perak" {{ request('pelabuhan_asal') == 'Tanjung Perak' ? 'selected' : '' }}>Tanjung Perak</option>
                    <option value="Merak" {{ request('pelabuhan_asal') == 'Merak' ? 'selected' : '' }}>Merak</option>
                    <option value="Bakauheni" {{ request('pelabuhan_asal') == 'Bakauheni' ? 'selected' : '' }}>Bakauheni</option>
                    <option value="Gilimanuk" {{ request('pelabuhan_asal') == 'Gilimanuk' ? 'selected' : '' }}>Gilimanuk</option>
                    <option value="Ketapang" {{ request('pelabuhan_asal') == 'Ketapang' ? 'selected' : '' }}>Ketapang</option>
                    <option value="Surabaya" {{ request('pelabuhan_asal') == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                    <option value="Jakarta" {{ request('pelabuhan_asal') == 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                </select>

                <!-- Filter Pelabuhan Tujuan -->
                <select name="pelabuhan_tujuan" class="h-[42px] border border-gray-300 rounded-lg px-4 bg-white text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    <option value="">Pelabuhan Tujuan</option>
                    <option value="Tanjung Perak" {{ request('pelabuhan_tujuan') == 'Tanjung Perak' ? 'selected' : '' }}>Tanjung Perak</option>
                    <option value="Merak" {{ request('pelabuhan_tujuan') == 'Merak' ? 'selected' : '' }}>Merak</option>
                    <option value="Bakauheni" {{ request('pelabuhan_tujuan') == 'Bakauheni' ? 'selected' : '' }}>Bakauheni</option>
                    <option value="Gilimanuk" {{ request('pelabuhan_tujuan') == 'Gilimanuk' ? 'selected' : '' }}>Gilimanuk</option>
                    <option value="Ketapang" {{ request('pelabuhan_tujuan') == 'Ketapang' ? 'selected' : '' }}>Ketapang</option>
                    <option value="Padangbai" {{ request('pelabuhan_tujuan') == 'Padangbai' ? 'selected' : '' }}>Padangbai</option>
                    <option value="Lembar" {{ request('pelabuhan_tujuan') == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                </select>

                <!-- Search Input -->
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kapal atau kode..."
                    class="flex-1 min-w-[100px] h-[42px] border border-gray-300 rounded-lg px-4 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                />
            </form>

            <!-- Right: Action Buttons -->
            <div class="flex gap-3 flex-shrink-0">
                <button type="submit" form="filter-form" class="h-[42px] px-8 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition text-sm font-medium whitespace-nowrap flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>

                <button onclick="document.getElementById('addScheduleModal').classList.remove('hidden')" class="h-[42px] px-8 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition text-sm font-medium whitespace-nowrap flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Jadwal
                </button>

                <button onclick="syncData()" class="h-[42px] px-8 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition text-sm font-medium whitespace-nowrap flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Sinkron
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <button onclick="return false;" class="p-2 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                <i data-feather="chevron-left" class="w-5 h-5"></i>
            </button>
            <h3 class="text-lg font-semibold text-slate-900">Oktober 2025</h3>
            <button onclick="return false;" class="p-2 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                <i data-feather="chevron-right" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">MON</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">TUE</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">WED</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">THU</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">FRI</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">SAT</th>
                        <th class="p-3 text-xs font-semibold text-slate-600 text-center">SUN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $fixedDate = Carbon\Carbon::create(2025, 10, 1);
                        $startOfMonth = $fixedDate->copy()->startOfMonth();
                        $endOfMonth = $fixedDate->copy()->endOfMonth();
                        $startDay = $startOfMonth->copy()->startOfWeek(Carbon\Carbon::MONDAY);
                        $endDay = $endOfMonth->copy()->endOfWeek(Carbon\Carbon::SUNDAY);
                        $currentDay = $startDay->copy();
                    @endphp

                    @while($currentDay <= $endDay)
                        <tr class="border-b border-slate-200">
                            @for($i = 0; $i < 7; $i++)
                                <td class="p-3 align-top h-24 {{ $currentDay->month != 10 ? 'bg-slate-50 text-slate-400' : '' }} {{ $currentDay->isToday() ? 'bg-blue-50' : '' }} hover:bg-slate-50 transition">
                                    <div class="font-semibold text-sm mb-1">{{ $currentDay->day }}</div>
                                    @if($currentDay->month == 10 && $currentDay->year == 2025)
                                        @php
                                            $dayJadwals = $jadwals->get($currentDay->format('Y-m-d'), collect());
                                        @endphp
                                        @if($dayJadwals->count() > 0)
                                            <div class="flex items-center gap-1 text-xs">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md flex items-center gap-1">
                                                    <i data-feather="anchor" class="w-3 h-3"></i>
                                                    <span>{{ $dayJadwals->count() }}</span>
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                @php $currentDay->addDay(); @endphp
                            @endfor
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>

    <!-- Jadwal Keberangkatan Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Jadwal Keberangkatan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">ID_Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Nama Kapal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Pelabuhan Asal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Pelabuhan Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Jam Berangkat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Estimasi Kedatangan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($jadwalKeberangkatan as $jadwal)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $jadwal->id_jadwal }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $jadwal->kapal->nama_kapal }}</div>
                                @if($jadwal->kapal->operator)
                                    <div class="text-xs text-slate-500">{{ $jadwal->kapal->operator->nama_operator ?? '' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $jadwal->pelabuhan_asal }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $jadwal->pelabuhan_tujuan }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $jadwal->jam_berangkat_formatted }} WIB</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $jadwal->estimasi_kedatangan_formatted }} WITA</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $jadwal->status == 'On-Time' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $jadwal->status == 'Delay' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $jadwal->status == 'Cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $jadwal->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($jadwal->keterangan, 50) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg transition">
                                        <i data-feather="edit-2" class="w-4 h-4"></i>
                                    </button>
                                    <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada jadwal keberangkatan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        @if(isset($jadwalKeberangkatan) && $jadwalKeberangkatan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-center items-center gap-3">
        {{-- Previous --}}
        @if ($jadwalKeberangkatan->onFirstPage())
        <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
            ← Previous
        </button>
        @else
            <a href="{{ $jadwalKeberangkatan->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                ← Previous
            </a>
        @endif

        {{-- Numbers --}}
        <div class="flex gap-2">
            @foreach ($jadwalKeberangkatan->getUrlRange(1, $jadwalKeberangkatan->lastPage()) as $page => $url)
                @if ($page == $jadwalKeberangkatan->currentPage())
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
        @if ($jadwalKeberangkatan->hasMorePages())
            <a href="{{ $jadwalKeberangkatan->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
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
    </div>


    <!-- Log Perubahan Jadwal -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Log Perubahan Jadwal</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Tanggal & Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">ID Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Nama Kapal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Perubahan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Diubah Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($logPerubahan as $log)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm">
                                <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $log->jenis_perubahan == 'created' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $log->jenis_perubahan == 'updated' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $log->jenis_perubahan == 'status_changed' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $log->jenis_perubahan == 'deleted' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $log->jenis_perubahan_text }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $log->id_jadwal }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-900">{{ $log->nama_kapal }}</div>
                                @if($log->kapal)
                                    <div class="text-xs text-slate-500">{{ $log->kapal->jenis_kapal ?? '' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ Str::limit($log->perubahan, 80) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-900">{{ $log->diubah_oleh }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $log->alasan_perubahan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <button onclick="showLogDetail({{ $log->id }})" class="p-2 text-cyan-600 hover:bg-cyan-50 rounded-lg transition">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                Tidak ada log perubahan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($logPerubahan) && $logPerubahan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-center items-center gap-3">
        {{-- Previous --}}
        @if ($logPerubahan->onFirstPage())
        <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
            ← Previous
        </button>
        @else
            <a href="{{ $logPerubahan->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                ← Previous
            </a>
        @endif

        {{-- Numbers --}}
        <div class="flex gap-2">
            @foreach ($logPerubahan->getUrlRange(1, $logPerubahan->lastPage()) as $page => $url)
                @if ($page == $logPerubahan->currentPage())
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
        @if ($jadwalKeberangkatan->hasMorePages())
            <a href="{{ $jadwalKeberangkatan->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
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
    </div>
<!-- Modal Add Schedule -->
<div id="addScheduleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-slate-900">Tambah Jadwal Baru</h3>
                <button onclick="document.getElementById('addScheduleModal').classList.add('hidden')" class="p-2 hover:bg-slate-100 rounded-lg">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('jadwal-kapal.store') }}" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kapal</label>
                    <select name="id_kapal" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Pilih Kapal</option>
                        @foreach($kapals ?? [] as $kapal)
                            <option value="{{ $kapal->id }}">{{ $kapal->nama_kapal }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pelabuhan Asal</label>
                        <select name="pelabuhan_asal" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">Pilih Pelabuhan</option>
                            <option value="Tanjung Perak">Tanjung Perak</option>
                            <option value="Merak">Merak</option>
                            <option value="Bakauheni">Bakauheni</option>
                            <option value="Gilimanuk">Gilimanuk</option>
                            <option value="Ketapang">Ketapang</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pelabuhan Tujuan</label>
                        <select name="pelabuhan_tujuan" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="">Pilih Pelabuhan</option>
                            <option value="Tanjung Perak">Tanjung Perak</option>
                            <option value="Merak">Merak</option>
                            <option value="Bakauheni">Bakauheni</option>
                            <option value="Padangbai">Padangbai</option>
                            <option value="Lembar">Lembar</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Keberangkatan</label>
                        <input type="date" name="tanggal_keberangkatan" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jam Berangkat</label>
                        <input type="time" name="jam_berangkat" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi Kedatangan</label>
                    <input type="datetime-local" name="estimasi_kedatangan" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="On-Time">Tepat Waktu</option>
                        <option value="Delay">Terlambat</option>
                        <option value="Cancelled">Dibatalkan</option>
                        <option value="Pending">Menunggu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('addScheduleModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function syncData() {
    if (!confirm('Yakin ingin melakukan sinkronisasi data?')) return;

    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Sinkronisasi...';

    fetch('{{ route("jadwal-kapal.sync") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sinkronisasi berhasil!');
            location.reload();
        } else {
            alert('Sinkronisasi gagal: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat sinkronisasi');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    });
}

function editJadwal(id) {
    window.location.href = `/jadwal-kapal/${id}/edit`;
}

function showLogDetail(id) {
    window.location.href = `/jadwal-kapal/log/${id}`;
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>

@endsection
