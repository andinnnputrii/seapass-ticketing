@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
  $formattedRevenue = 'Rp '.number_format($stats['revenue'] ?? 0, 0, ',', '.');
@endphp

  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    <x-stat-card
      title="Tiket Terjual Hari Ini"
      :value="$stats['ticketsToday'] ?? 0"
      suffix="/tiket"
      note="3,5% • Update per pukul 14:00"
      noteColor="text-emerald-600"
      bg="bg-violet-100"
    />
    <x-stat-card
      title="Penumpang Aktif Hari Ini"
      :value="$stats['passengersToday'] ?? 0"
      suffix="Penumpang"
      note="4,8% • Naik dibandingkan kemarin"
      noteColor="text-emerald-600"
      bg="bg-blue-100"
    />
    <div class="bg-white border border-slate-200 rounded-lg p-4">
        <div class="flex justify-between items-start">
       <!-- Bagian Tiket Terjual -->
    <div>
        <div class="text-sm text-slate-500">Tiket Terjual</div>
        <div class="mt-3 flex items-center gap-8">
          <div>
            <div class="text-2xl font-semibold text-express">
              {{ number_format($stats['expressTotal'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Express</div>
          </div>
          <div>
            <div class="text-2xl font-semibold text-regular">
              {{ number_format($stats['regularTotal'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Regular</div>
          </div>
        </div>
      </div>

      <!-- Bagian Kapal Beroperasi di sebelah kanan -->
    <div class="text-right">
      <div class="text-sm text-slate-500">Kapal Beroperasi Minggu Ini</div>
      <div class="mt-1 text-3xl font-semibold">
        {{ isset($stats['opsRate']) ? round($stats['opsRate']*100) : 0 }}%
      </div>
      <div class="text-xs text-slate-500 mt-1">85 dari 96 kapal</div>
    </div>
  </div>
</div>

    <div class="bg-white border border-slate-200 rounded-lg p-4">
      <div class="text-sm text-slate-500">Pendapatan</div>
      <div class="mt-2 text-3xl font-semibold text-brand-800">{{ $formattedRevenue }}</div>
      <div class="mt-3 flex items-center gap-2 text-xs text-rose-600">
        <i data-feather="trending-down" class="w-4 h-4"></i>
        <span>1,2% • Turun dibandingkan kemarin</span>
      </div>
    </div>
  </div>

  {{-- Chart --}}
  <div class="mt-6">
    <x-line-chart
      :labels="$chart['labels'] ?? []"
      :datasets="['express' => ($chart['express'] ?? []), 'regular' => ($chart['regular'] ?? [])]"
      height="240"
    />
  </div>

  {{-- Table: Jadwal Keberangkatan --}}
  <div class="mt-6 bg-white border border-slate-200 rounded-lg">
    <div class="px-4 py-3 border-b border-slate-200 font-semibold">
      Jadwal Keberangkatan
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="px-4 py-3 text-left">ID_Jadwal</th>
            <th class="px-4 py-3 text-left">Nama Kapal</th>
            <th class="px-4 py-3 text-left">Pelabuhan Asal</th>
            <th class="px-4 py-3 text-left">Pelabuhan Tujuan</th>
            <th class="px-4 py-3 text-left">Jam Berangkat</th>
            <th class="px-4 py-3 text-left">Estimasi Kedatangan</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-left">Keterangan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @foreach(($schedule ?? []) as $row)
            <tr class="hover:bg-slate-50">
              <td class="px-4 py-3 font-medium text-slate-700">{{ $row['id'] ?? '-' }}</td>
              <td class="px-4 py-3">{{ $row['ship'] ?? '-' }}</td>
              <td class="px-4 py-3 text-slate-600">{{ $row['from'] ?? '-' }}</td>
              <td class="px-4 py-3 text-slate-600">{{ $row['to'] ?? '-' }}</td>
              <td class="px-4 py-3">{{ $row['depart'] ?? '-' }}</td>
              <td class="px-4 py-3">{{ $row['eta'] ?? '-' }}</td>
              <td class="px-4 py-3">
                @php
                  $c = ($row['status_color'] ?? 'teal');
                  $color = $c === 'teal' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'
                         : ($c === 'amber' ? 'bg-amber-50 text-amber-700 ring-amber-600/20'
                         : 'bg-slate-100 text-slate-700 ring-slate-600/20');
                @endphp
                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs ring-1 ring-inset {{ $color }}">
                  {{ $row['status'] ?? '-' }}
                </span>
              </td>
              <td class="px-4 py-3 text-slate-600">{{ $row['note'] ?? '-' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="px-4 py-3 border-t border-slate-200 flex items-centeFr justify-between text-sm">
      <button class="px-3 py-1.5 rounded-md border border-slate-200 hover:bg-slate-50">‹ Previous</button>
      <div class="flex items-center gap-1">
        <button class="w-8 h-8 rounded-md bg-brand-50 text-brand-700">1</button>
        <button class="w-8 h-8 rounded-md hover:bg-slate-100">2</button>
        <span class="px-2 text-slate-500">…</span>
        <button class="w-8 h-8 rounded-md hover:bg-slate-100">20</button>
      </div>
      <button class="px-3 py-1.5 rounded-md border border-slate-200 hover:bg-slate-50">Next ›</button>
    </div>
  </div>

  @endsection

