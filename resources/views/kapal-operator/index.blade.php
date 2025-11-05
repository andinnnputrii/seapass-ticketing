@extends('layouts.app')

@section('content')
  <div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-wrap items-center justify-between mb-6">
        {{-- Judul + Breadcrumb --}}
        <div>
        <h2 class="text-2xl font-semibold text-slate-800 mb-1">Kapal & Operator</h2>
        <nav class="text-sm text-teal-600 font-medium">
            <span>Kapal & Operator</span>
            <span class="mx-2">></span>
            <span>{{ request('view') == 'operator' ? 'Data Operator' : 'Data Kapal' }}</span>
        </nav>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-2">
        <button
            class="bg-teal-700 hover:bg-teal-800 text-white px-4 py-2.5 rounded-md text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Sinkronisasi Data
        </button>

        @if(request('view') == 'operator')
            <a href="{{ route('operator.create') }}"
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2.5 rounded-md text-sm font-medium transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Operator
            </a>
        @else
            <a href="{{ route('kapal-operator.create') }}"
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2.5 rounded-md text-sm font-medium transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kapal
            </a>
        @endif


        <button
            class="bg-yellow-400 hover:bg-yellow-500 text-slate-800 px-4 py-2.5 rounded-md text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit
        </button>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      {{-- Total Kapal --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-all">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $totalKapal ?? 115 }}</p>
            <p class="text-sm text-slate-600 font-medium">Total Kapal</p>
          </div>
          <div class="bg-blue-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ship-icon lucide-ship"><path d="M12 10.189V14"/><path d="M12 2v3"/><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-8.188-3.639a2 2 0 0 0-1.624 0L3 14a11.6 11.6 0 0 0 2.81 7.76"/><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1s1.2 1 2.5 1c2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>
            </svg>
          </div>
        </div>
      </div>

      {{-- Beroperasi --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-all">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $beroperasi ?? 96 }}</p>
            <p class="text-sm text-slate-600 font-medium">Beroperasi</p>
          </div>
          <div class="bg-cyan-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag-triangle-right-icon lucide-flag-triangle-right"><path d="M6 22V2.8a.8.8 0 0 1 1.17-.71l11.38 5.69a.8.8 0 0 1 0 1.44L6 15.5"/>
            </svg>
          </div>
        </div>
      </div>

      {{-- Pemeliharaan --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-all">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $pemeliharaan ?? 14 }}</p>
            <p class="text-sm text-slate-600 font-medium">Pemeliharaan</p>
          </div>
          <div class="bg-yellow-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-construction-icon lucide-construction"><rect x="2" y="6" width="20" height="8" rx="1"/><path d="M17 14v7"/><path d="M7 14v7"/><path d="M17 3v3"/><path d="M7 3v3"/><path d="M10 14 2.3 6.3"/><path d="m14 6 7.7 7.7"/><path d="m8 6 8 8"/>
            </svg>
          </div>
        </div>
      </div>

      {{-- Tidak Beroperasi --}}
      <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-all">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $tidakBeroperasi ?? 5 }}</p>
            <p class="text-sm text-slate-600 font-medium">Tidak Beroperasi</p>
          </div>
          <div class="bg-pink-100 p-3 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban"><path d="M4.929 4.929 19.07 19.071"/><circle cx="12" cy="12" r="10"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
      <form method="GET" class="flex flex-col lg:flex-row gap-4">
        <div class="flex items-center gap-3">
          <button type="button" class="flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium px-4 py-2 rounded-lg hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span>Filter</span>
          </button>

          <div class="relative">
            <input type="text" name="search" placeholder="Cari" value="{{ request('search') }}"
                   class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
        </div>
      </form>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-slate-200">
      <div class="flex gap-8">
        <a href="{{ route('kapal-operator.index', ['view' => 'kapal']) }}"
           class="pb-4 px-2 text-sm font-semibold transition-colors flex items-center gap-2 relative {{ request('view', 'kapal') == 'kapal' ? 'text-teal-600' : 'text-slate-500 hover:text-slate-700' }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
          </svg>
          Data Kapal
          @if(request('view', 'kapal') == 'kapal')
            <span class="absolute bottom-0 left-0 right-0 h-1 bg-teal-600 rounded-t"></span>
          @endif
        </a>

        <a href="{{ route('kapal-operator.index', ['view' => 'operator']) }}"
           class="pb-4 px-2 text-sm font-semibold transition-colors flex items-center gap-2 relative {{ request('view') == 'operator' ? 'text-teal-600' : 'text-slate-500 hover:text-slate-700' }}">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          Data Operator
          @if(request('view') == 'operator')
            <span class="absolute bottom-0 left-0 right-0 h-1 bg-teal-600 rounded-t"></span>
          @endif
        </a>
      </div>
    </div>

        {{-- Cek apakah sedang menampilkan kapal atau operator --}}
        @if($view === 'kapal')
        {{-- ===================== TABEL KAPAL ===================== --}}
        <table class="min-w-full text-sm border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Kapal</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jenis</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kapasitas</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status Operasional</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Operator</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
            @forelse ($kapals as $kapal)
                <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4 font-medium text-slate-800">{{ $kapal->nama_kapal }}</td>
                <td class="px-6 py-4">{{ $kapal->jenis_kapal ?? '-' }}</td>
                <td class="px-6 py-4">{{ $kapal->kapasitas ?? '-' }}</td>
                <td class="px-6 py-4">{{ $kapal->status_operasional ?? '-' }}</td>
                <td class="px-6 py-4">{{ $kapal->operator->nama_operator ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                <td colspan="5" class="px-6 py-4 text-center text-slate-500">Tidak ada data kapal.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @elseif($view === 'operator')
        {{-- ===================== TABEL OPERATOR ===================== --}}
        <div class="overflow-x-auto bg-white border border-slate-200 rounded-lg shadow-sm">
        <table class="min-w-full text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider font-semibold border-b border-slate-200">
            <tr>
                <th class="px-6 py-4 text-left">Operator ID</th>
                <th class="px-6 py-4 text-left">Nama Perusahaan</th>
                <th class="px-6 py-4 text-left">Alamat Kantor</th>
                <th class="px-6 py-4 text-left">No. Kontak</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Kapal Dikelola</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
            @forelse ($operators as $operator)
                <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-4 font-medium text-slate-800">{{ $operator->operator_id }}</td>
                <td class="px-6 py-4">{{ $operator->nama_operator }}</td>
                <td class="px-6 py-4">{{ $operator->alamat_kantor ?? '-' }}</td>
                <td class="px-6 py-4">{{ $operator->kontak ?? '-' }}</td>
                <td class="px-6 py-4">{{ $operator->email ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($operator->kapal && $operator->kapal->count() > 0)
                    {{ $operator->kapal->pluck('kapal_id')->implode(', ') }}
                    @else
                    -
                    @endif
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="6" class="px-6 py-4 text-center text-slate-500">Tidak ada data operator.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $operators->links() }}
        </div>
        </div>
        @endif


        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
          <div class="flex items-center justify-between">
            <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Previous
            </button>

            <div class="flex items-center gap-2">
              <button class="px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg">1</button>
              <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition">2</button>
              <span class="px-2 text-slate-500">...</span>
              <button class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 rounded-lg transition">20</button>
            </div>

            <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
              Next
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>


    {{-- Modal Sinkronisasi --}}
    <dialog id="syncModal" class="rounded-xl shadow-2xl p-0 w-full max-w-md backdrop:bg-black backdrop:bg-opacity-50 border-0">
      <div class="bg-white p-6 rounded-xl">
        <h2 class="text-xl font-bold text-slate-800 mb-2">Sinkronisasi Data</h2>
        <p class="text-slate-600 text-sm mb-6">
          Sinkronisasi akan memperbarui data kapal dan operator dari sumber eksternal. Pastikan koneksi internet stabil.
        </p>
        <div class="flex justify-end gap-3">
          <button type="button" onclick="this.closest('dialog').close()"
                  class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">
            Batal
          </button>
          <form method="POST" action="{{ route('kapal-operator.sync') }}" class="inline">
            @csrf
            <button type="submit"
                    class="bg-teal-700 hover:bg-teal-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-md">
              Mulai Sinkronisasi
            </button>
          </form>
        </div>
      </div>
    </dialog>
  </div>
@endsection
