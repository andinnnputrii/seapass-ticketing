<x-layouts.app :title="'Detail Transaksi'">
  <!-- Back Button & Breadcrumb -->
  <div class="mb-6">
    <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 mb-4">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
      Kembali ke Transaksi
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Transaction Details -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Transaction Info -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800">Informasi Transaksi</h2>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nomor Transaksi</p>
              <p class="font-semibold text-gray-900">{{ $transaction->order_number }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Status Pembayaran</p>
              <div class="mt-1">{!! $transaction->getStatusBadge() !!}</div>
            </div>
            <div>
              <p class="text-sm text-gray-600">Tanggal Transaksi</p>
              <p class="font-semibold text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Metode Pembayaran</p>
              <p class="font-semibold text-gray-900">{{ $transaction->payment_method }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Total Pembayaran</p>
              <p class="font-semibold text-teal-600 text-xl">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
            </div>
            @if($transaction->paid_at)
              <div>
                <p class="text-sm text-gray-600">Dibayar Pada</p>
                <p class="font-semibold text-gray-900">{{ $transaction->paid_at->format('d M Y, H:i') }}</p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Passenger Info -->
      <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-800">Data Penumpang</h2>
        </div>
        <div class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nama Lengkap</p>
              <p class="font-semibold text-gray-900">{{ $transaction->passenger_name }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nomor Telepon</p>
              <p class="font-semibold text-gray-900">{{ $transaction->passenger_phone ?? '-' }}</p>
            </div>
            <div class="col-span-2">
              <p class="text-sm text-gray-600">Email</p>
              <p class="font-semibold text-gray-900">{{ $transaction->passenger_email ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Schedule Info -->
      @if($transaction->ticket && $transaction->ticket->schedule)
        <div class="bg-white rounded-lg shadow">
          <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Jadwal</h2>
          </div>
          <div class="p-6 space-y-4">
            @php
              $schedule = $transaction->ticket->schedule;
            @endphp
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-600">Nama Kapal</p>
                <p class="font-semibold text-gray-900">{{ $schedule->ship->name ?? '-' }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600">Rute</p>
                <p class="font-semibold text-gray-900">{{ $schedule->departure_port }} → {{ $schedule->arrival_port }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600">Tanggal Keberangkatan</p>
                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-600">Waktu Keberangkatan</p>
                <p class="font-semibold text-gray-900">{{ $schedule->departure_time }}</p>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

    <!-- Right Column: Actions & Refund -->
    <div class="space-y-6">
      <!-- Quick Actions -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
          @if($transaction->payment_status === 'paid')
            <button class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
              <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
              </svg>
              Download E-Ticket
            </button>
          @endif
          
          <button onclick="window.print()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Invoice
          </button>
        </div>
      </div>

      <!-- Refund Info -->
      @if($transaction->refund)
        <div class="bg-white rounded-lg shadow p-6">
          <h3 class="font-semibold text-gray-800 mb-4">Status Refund</h3>
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-600">Nomor Refund</p>
              <p class="font-semibold text-gray-900">{{ $transaction->refund->refund_number }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Jumlah Refund</p>
              <p class="font-semibold text-teal-600">Rp {{ number_format($transaction->refund->refund_amount, 0, ',', '.') }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Alasan</p>
              <p class="text-gray-900">{{ $transaction->refund->reason }}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <div class="mt-1">{!! $transaction->refund->getStatusBadge() !!}</div>
            </div>
            @if($transaction->refund->status === 'pending')
              <div class="pt-3 border-t space-y-2">
                <form action="{{ route('admin.refunds.approve', $transaction->refund->id) }}" method="POST">
                  @csrf
                  <button 
                    type="submit"
                    onclick="return confirm('Setujui refund ini?')"
                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                  >
                    Setujui Refund
                  </button>
                </form>
                <form action="{{ route('admin.refunds.reject', $transaction->refund->id) }}" method="POST">
                  @csrf
                  <button 
                    type="submit"
                    onclick="return confirm('Tolak refund ini?')"
                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                  >
                    Tolak Refund
                  </button>
                </form>
              </div>
            @endif
            @if($transaction->refund->approved_by)
              <div class="pt-3 border-t">
                <p class="text-sm text-gray-600">Diproses Oleh</p>
                <p class="font-semibold text-gray-900">{{ $transaction->refund->approvedBy->name ?? '-' }}</p>
                <p class="text-xs text-gray-500">{{ $transaction->refund->approved_at->format('d M Y, H:i') }}</p>
              </div>
            @endif
          </div>
        </div>
      @endif

      <!-- Transaction Timeline -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Timeline</h3>
        <div class="space-y-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <p class="text-sm font-semibold text-gray-900">Transaksi Dibuat</p>
              <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
            </div>
          </div>

          @if($transaction->paid_at)
            <div class="flex">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                  <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-semibold text-gray-900">Pembayaran Berhasil</p>
                <p class="text-xs text-gray-500">{{ $transaction->paid_at->format('d M Y, H:i') }}</p>
              </div>
            </div>
          @endif

          @if($transaction->refund)
            <div class="flex">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                  <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <p class="text-sm font-semibold text-gray-900">Pengajuan Refund</p>
                <p class="text-xs text-gray-500">{{ $transaction->refund->created_at->format('d M Y, H:i') }}</p>
              </div>
            </div>

            @if($transaction->refund->approved_at)
              <div class="flex">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 {{ $transaction->refund->status === 'approved' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 {{ $transaction->refund->status === 'approved' ? 'text-green-600' : 'text-red-600' }}" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                  </div>
                </div>
                <div class="ml-4">
                  <p class="text-sm font-semibold text-gray-900">
                    Refund {{ $transaction->refund->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                  </p>
                  <p class="text-xs text-gray-500">{{ $transaction->refund->approved_at->format('d M Y, H:i') }}</p>
                </div>
              </div>
            @endif
          @endif
        </div>
      </div>

      <!-- Notes -->
      @if($transaction->notes)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-yellow-800">Catatan</h3>
              <div class="mt-2 text-sm text-yellow-700">
                {{ $transaction->notes }}
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in">
      {{ session('success') }}
    </div>
  @endif
</x-layouts.app>