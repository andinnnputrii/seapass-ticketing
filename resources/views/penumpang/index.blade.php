@extends('layouts.app')

@section('content')
<div class="container-fluid px-6 py-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        {{-- Judul + Breadcrumb --}}
        <div>
            <h2 class="text-2xl font-semibold text-slate-800 mb-1">Data Penumpang</h2>
            <nav class="flex items-center text-sm text-teal-600">
                <span>Data Penumpang</span>
                <span class="mx-2">></span>
                <span class="font-semibold">Daftar Penumpang</span>
            </nav>
        </div>

        {{-- Tombol Tambah --}}
        <a href="{{ route('penumpang.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Penumpang
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <!-- Total Penumpang -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 mb-1">Total Penumpang</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalPenumpang) }}</h3>
                </div>
            </div>
        </div>

        <!-- Laki-laki -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalLakiLaki) }}</h3>
                <p class="text-sm text-gray-600">Laki-laki</p>
            </div>
        </div>

        <!-- Perempuan -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalPerempuan) }}</h3>
                <p class="text-sm text-gray-600">Perempuan</p>
            </div>
        </div>

        <!-- Tiket Aktif -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-green-600">{{ number_format($tiketAktif) }}</h3>
                <p class="text-sm text-gray-600">Tiket Aktif</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
        <form method="GET" action="{{ route('penumpang.index') }}" class="flex items-center gap-4">
            <!-- Filter Status -->
            <div class="flex items-center gap-2">
                <button type="button" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>

                <select name="jenis_kelamin"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-500"
                        onchange="this.form.submit()">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Search -->
            <div class="relative flex-1 max-w-md">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama, NIK, atau nomor telepon..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-200 focus:border-teal-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            @if(request('search') || request('jenis_kelamin'))
            <a href="{{ route('penumpang.index') }}"
               class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">
                Reset Filter
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nama Penumpang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tiket Aktif</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status Tiket</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Rute</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penumpangs as $penumpang)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $penumpang->penumpang_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $penumpang->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $penumpang->nik ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $penumpang->umur ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="inline-flex items-center gap-1">
                                @if($penumpang->jenis_kelamin == 'Laki-laki')
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                @else
                                    <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                                @endif
                                {{ $penumpang->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $penumpang->tiket_aktif ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($penumpang->latest_tiket)
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    {{ $penumpang->latest_tiket->status_tiket == 'Valid' ? 'bg-green-100 text-green-700' :
                                       ($penumpang->latest_tiket->status_tiket == 'Batal' ? 'bg-red-100 text-red-700' :
                                       ($penumpang->latest_tiket->status_tiket == 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')) }}">
                                    {{ $penumpang->latest_tiket->status_tiket }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                    Tidak Ada Tiket
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $penumpang->rute ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Detail -->
                                <a href="{{ route('penumpang.show', $penumpang->penumpang_id) }}"
                                   class="p-1 text-blue-600 hover:bg-blue-50 rounded transition"
                                   title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('penumpang.edit', $penumpang->penumpang_id) }}"
                                   class="p-1 text-yellow-600 hover:bg-yellow-50 rounded transition"
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('penumpang.destroy', $penumpang->penumpang_id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penumpang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1 text-red-600 hover:bg-red-50 rounded transition"
                                            title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-lg font-medium mb-1">Tidak ada data penumpang</p>
                            <p class="text-sm">Mulai tambahkan data penumpang baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($penumpangs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <!-- Info -->
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $penumpangs->firstItem() }} - {{ $penumpangs->lastItem() }} dari {{ $penumpangs->total() }} penumpang
                </div>

                <!-- Pagination Buttons -->
                <div class="flex items-center gap-3">
                    {{-- Previous --}}
                    @if ($penumpangs->onFirstPage())
                        <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                            ← Previous
                        </button>
                    @else
                        <a href="{{ $penumpangs->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                            ← Previous
                        </a>
                    @endif

                    {{-- Numbers --}}
                    <div class="flex gap-2">
                        @foreach ($penumpangs->getUrlRange(1, $penumpangs->lastPage()) as $page => $url)
                            @if ($page == $penumpangs->currentPage())
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
                    @if ($penumpangs->hasMorePages())
                        <a href="{{ $penumpangs->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg hover:border-teal-500 hover:text-teal-600 transition-colors">
                            Next →
                        </a>
                    @else
                        <button disabled class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed opacity-50">
                            Next →
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
    {{ session('error') }}
</div>
@endif
@endsection
