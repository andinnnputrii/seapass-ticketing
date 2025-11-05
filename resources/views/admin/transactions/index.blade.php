@php
  $formattedTotal = 'Rp ' . number_format($totalTransactions ?? 0, 0, ',', '.');
@endphp

<x-layouts.app :title="'Transaksi & Refund'">
  <!-- Breadcrumb -->
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Transaksi & Refund</h1>
      <nav class="flex mt-2 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-teal-600 font-medium">Transaksi & Refund</span>
        <span class="mx-2">/</span>
        <a href="#riwayat-transaksi" class="hover:text-teal-600">Riwayat Transaksi</a>
      </nav>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <!-- Total Transaksi -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Total Transaksi</p>
          <p class="text-xl font-bold text-gray-800">{{ $formattedTotal }}</p>
        </div>
        <div class="p-3 bg-purple-100 rounded-lg">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Pengajuan Refund -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-pink-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Pengajuan Refund</p>
          <p class="text-xl font-bold text-gray-800">{{ $pendingRefunds }}</p>
        </div>
        <div class="p-3 bg-pink-100 rounded-lg">
          <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Berhasil (Paid) -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Berhasil</p>
          <p class="text-xl font-bold text-gray-800">{{ $successfulTransactions }}</p>
        </div>
        <div class="p-3 bg-green-100 rounded-lg">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Pending -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Pending</p>
          <p class="text-xl font-bold text-gray-800">{{ $pendingPayments }}</p>
        </div>
        <div class="p-3 bg-yellow-100 rounded-lg">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Refund -->
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-gray-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Refund</p>
          <p class="text-xl font-bold text-gray-800">{{ $refundedTransactions }}</p>
        </div>
        <div class="p-3 bg-gray-100 rounded-lg">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter & Search -->
  <div class="bg-white rounded-lg shadow mb-6 p-4">
    <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-wrap gap-3 items-end">
      <!-- Filter Status -->
      <div class="flex-1 min-w-[200px]">
        <label class="block text-sm font-medium text-gray-700 mb-1">
          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
          </svg>
          Status
        </label>
        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
          <option value="">Semua Status</option>
          <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
          <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refund</option>
        </select>
      </div>

      <!-- Search -->
      <div class="flex-1 min-w-[300px]">
        <label class="block text-sm font-medium text-gray-700 mb-1">
          <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Cari
        </label>
        <input 
          type="text" 
          name="search" 
          value="{{ request('search') }}"
          placeholder="Cari nomor transaksi atau nama penumpang..." 
          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
        >
      </div>

      <!-- Buttons -->
      <div class="flex gap-2">
        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
          Filter
        </button>
        <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
          Reset
        </a>
      </div>
    </form>
  </div>

  <!-- Riwayat Transaksi Table -->
  <div class="bg-white rounded-lg shadow" id="riwayat-transaksi">
    <div class="px-6 py-4 border-b border-gray-200">
      <h2 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h2>
    </div>
    
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penumpang</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Rp)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Bayar</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($transactions as $transaction)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $transaction->order_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $transaction->passenger_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ number_format($transaction->amount, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $transaction->payment_method }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $transaction->created_at->format('Y-m-d H:i') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                {!! $transaction->getStatusBadge() !!}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <button 
                  onclick="window.location.href='{{ route('admin.transactions.show', $transaction->id) }}'"
                  class="inline-flex items-center px-3 py-1 bg-teal-100 text-teal-700 rounded hover:bg-teal-200 transition"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Detail
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="font-medium">Tidak ada transaksi</p>
                <p class="text-sm mt-1">Data transaksi akan muncul di sini</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $transactions->links() }}
      </div>
    @endif
  </div>

  <!-- Pengajuan Refund Section -->
  <div class="bg-white rounded-lg shadow mt-6">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
      <h2 class="text-lg font-semibold text-gray-800">Pengajuan Refund</h2>
      <a href="{{ route('admin.refunds.index') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
        Lihat Semua →
      </a>
    </div>
    
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Refund</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @php
            $pendingRefundsData = \App\Models\Refund::with('transaction')
              ->where('status', 'pending')
              ->latest()
              ->take(5)
              ->get();
          @endphp
          
          @forelse($pendingRefundsData as $refund)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $refund->refund_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $refund->transaction->order_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $refund->transaction->passenger_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                Rp {{ number_format($refund->refund_amount, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                {{ $refund->reason }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                {!! $refund->getStatusBadge() !!}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="flex gap-2">
                  <form action="{{ route('admin.refunds.approve', $refund->id) }}" method="POST" class="inline">
                    @csrf
                    <button 
                      type="submit"
                      onclick="return confirm('Setujui refund ini?')"
                      class="px-3 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200 transition"
                    >
                      Setujui
                    </button>
                  </form>
                  <form action="{{ route('admin.refunds.reject', $refund->id) }}" method="POST" class="inline">
                    @csrf
                    <button 
                      type="submit"
                      onclick="return confirm('Tolak refund ini?')"
                      class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                    >
                      Tolak
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium">Tidak ada pengajuan refund</p>
                <p class="text-sm mt-1">Pengajuan refund akan muncul di sini</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
      {{ session('success') }}
    </div>
  @endif
</x-layouts.app>