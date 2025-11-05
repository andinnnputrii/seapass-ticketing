<x-layouts.app :title="'Kelola Refund'">
  <!-- Breadcrumb -->
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kelola Refund</h1>
    <nav class="flex mt-2 text-sm text-gray-600">
      <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Dashboard</a>
      <span class="mx-2">/</span>
      <a href="{{ route('admin.transactions.index') }}" class="hover:text-teal-600">Transaksi</a>
      <span class="mx-2">/</span>
      <span class="text-teal-600 font-medium">Kelola Refund</span>
    </nav>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Menunggu Approval</p>
          <p class="text-2xl font-bold text-gray-800">{{ $refunds->where('status', 'pending')->count() }}</p>
        </div>
        <div class="p-3 bg-yellow-100 rounded-lg">
          <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Disetujui</p>
          <p class="text-2xl font-bold text-gray-800">{{ $refunds->where('status', 'approved')->count() }}</p>
        </div>
        <div class="p-3 bg-green-100 rounded-lg">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Ditolak</p>
          <p class="text-2xl font-bold text-gray-800">{{ $refunds->where('status', 'rejected')->count() }}</p>
        </div>
        <div class="p-3 bg-red-100 rounded-lg">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-teal-500">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 mb-1">Total Refund</p>
          <p class="text-2xl font-bold text-gray-800">{{ $refunds->count() }}</p>
        </div>
        <div class="p-3 bg-teal-100 rounded-lg">
          <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Tabs -->
  <div class="bg-white rounded-lg shadow mb-6">
    <div class="border-b border-gray-200">
      <nav class="flex -mb-px">
        <a href="{{ route('admin.refunds.index') }}" class="px-6 py-3 text-sm font-medium {{ !request('status') ? 'border-b-2 border-teal-600 text-teal-600' : 'text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          Semua ({{ $refunds->count() }})
        </a>
        <a href="{{ route('admin.refunds.index', ['status' => 'pending']) }}" class="px-6 py-3 text-sm font-medium {{ request('status') === 'pending' ? 'border-b-2 border-teal-600 text-teal-600' : 'text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          Pending ({{ $refunds->where('status', 'pending')->count() }})
        </a>
        <a href="{{ route('admin.refunds.index', ['status' => 'approved']) }}" class="px-6 py-3 text-sm font-medium {{ request('status') === 'approved' ? 'border-b-2 border-teal-600 text-teal-600' : 'text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          Disetujui ({{ $refunds->where('status', 'approved')->count() }})
        </a>
        <a href="{{ route('admin.refunds.index', ['status' => 'rejected']) }}" class="px-6 py-3 text-sm font-medium {{ request('status') === 'rejected' ? 'border-b-2 border-teal-600 text-teal-600' : 'text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          Ditolak ({{ $refunds->where('status', 'rejected')->count() }})
        </a>
      </nav>
    </div>
  </div>

  <!-- Refunds Table -->
  <div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Refund</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penumpang</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($refunds as $refund)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $refund->refund_number }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <a href="{{ route('admin.transactions.show', $refund->transaction_id) }}" class="text-teal-600 hover:text-teal-700">
                  {{ $refund->transaction->order_number }}
                </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $refund->transaction->passenger_name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                Rp {{ number_format($refund->refund_amount, 0, ',', '.') }}
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                <div class="truncate" title="{{ $refund->reason }}">
                  {{ Str::limit($refund->reason, 50) }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                {{ $refund->created_at->format('d M Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                {!! $refund->getStatusBadge() !!}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                @if($refund->status === 'pending')
                  <button 
                    onclick="openRefundModal({{ json_encode($refund) }})"
                    class="px-3 py-1 bg-teal-100 text-teal-700 rounded hover:bg-teal-200 transition"
                  >
                    Review
                  </button>
                @else
                  <button 
                    onclick="viewRefundDetail({{ json_encode($refund) }})"
                    class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition"
                  >
                    Detail
                  </button>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="font-medium">Tidak ada pengajuan refund</p>
                <p class="text-sm mt-1">Pengajuan refund akan muncul di sini</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($refunds->hasPages())
      <div class="px-6 py-4 border-t border-gray-200">
        {{ $refunds->links() }}
      </div>
    @endif
  </div>

  <!-- Modal Review Refund -->
  <div id="refundModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
      <div class="flex justify-between items-center pb-3 border-b">
        <h3 class="text-lg font-semibold text-gray-900">Review Pengajuan Refund</h3>
        <button onclick="closeRefundModal()" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <div id="modalContent" class="mt-4">
        <!-- Content will be injected by JavaScript -->
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
      {{ session('success') }}
    </div>
  @endif

  <script>
    function openRefundModal(refund) {
      const modal = document.getElementById('refundModal');
      const content = document.getElementById('modalContent');
      
      content.innerHTML = `
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nomor Refund</p>
              <p class="font-semibold text-gray-900">${refund.refund_number}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nomor Transaksi</p>
              <p class="font-semibold text-gray-900">${refund.transaction.order_number}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nama Penumpang</p>
              <p class="font-semibold text-gray-900">${refund.transaction.passenger_name}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Jumlah Refund</p>
              <p class="font-semibold text-teal-600">Rp ${new Intl.NumberFormat('id-ID').format(refund.refund_amount)}</p>
            </div>
          </div>
          
          <div>
            <p class="text-sm text-gray-600 mb-2">Alasan Refund</p>
            <div class="p-3 bg-gray-50 rounded-lg">
              <p class="text-gray-900">${refund.reason}</p>
            </div>
          </div>

          <form id="refundForm" class="space-y-3">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin (Opsional)</label>
              <textarea 
                name="admin_notes" 
                rows="3" 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                placeholder="Tambahkan catatan untuk pelanggan..."
              ></textarea>
            </div>

            <div class="flex gap-3 pt-4">
              <button 
                type="button"
                onclick="approveRefund(${refund.id})"
                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
              >
                Setujui Refund
              </button>
              <button 
                type="button"
                onclick="rejectRefund(${refund.id})"
                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
              >
                Tolak Refund
              </button>
            </div>
          </form>
        </div>
      `;
      
      modal.classList.remove('hidden');
    }

    function closeRefundModal() {
      document.getElementById('refundModal').classList.add('hidden');
    }

    function approveRefund(refundId) {
      if (!confirm('Yakin ingin menyetujui refund ini?')) return;
      
      const form = document.getElementById('refundForm');
      const formData = new FormData(form);
      
      fetch(`/admin/refunds/${refundId}/approve`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        closeRefundModal();
        location.reload();
      });
    }

    function rejectRefund(refundId) {
      if (!confirm('Yakin ingin menolak refund ini?')) return;
      
      const form = document.getElementById('refundForm');
      const formData = new FormData(form);
      
      fetch(`/admin/refunds/${refundId}/reject`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        closeRefundModal();
        location.reload();
      });
    }

    function viewRefundDetail(refund) {
      const modal = document.getElementById('refundModal');
      const content = document.getElementById('modalContent');
      
      const statusBadge = refund.status === 'approved' 
        ? '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>'
        : '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>';
      
      content.innerHTML = `
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nomor Refund</p>
              <p class="font-semibold text-gray-900">${refund.refund_number}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Status</p>
              <div class="mt-1">${statusBadge}</div>
            </div>
            <div>
              <p class="text-sm text-gray-600">Nomor Transaksi</p>
              <p class="font-semibold text-gray-900">${refund.transaction.order_number}</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Jumlah Refund</p>
              <p class="font-semibold text-teal-600">Rp ${new Intl.NumberFormat('id-ID').format(refund.refund_amount)}</p>
            </div>
            <div class="col-span-2">
              <p class="text-sm text-gray-600">Nama Penumpang</p>
              <p class="font-semibold text-gray-900">${refund.transaction.passenger_name}</p>
            </div>
          </div>
          
          <div>
            <p class="text-sm text-gray-600 mb-2">Alasan Refund</p>
            <div class="p-3 bg-gray-50 rounded-lg">
              <p class="text-gray-900">${refund.reason}</p>
            </div>
          </div>

          ${refund.admin_notes ? `
            <div>
              <p class="text-sm text-gray-600 mb-2">Catatan Admin</p>
              <div class="p-3 bg-blue-50 rounded-lg">
                <p class="text-gray-900">${refund.admin_notes}</p>
              </div>
            </div>
          ` : ''}

          ${refund.approved_by ? `
            <div class="pt-3 border-t">
              <p class="text-sm text-gray-600">Diproses Oleh</p>
              <p class="font-semibold text-gray-900">${refund.approved_by.name || 'Admin'}</p>
              <p class="text-xs text-gray-500">${new Date(refund.approved_at).toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
              })}</p>
            </div>
          ` : ''}

          <div class="flex justify-end pt-4">
            <button 
              onclick="closeRefundModal()"
              class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
            >
              Tutup
            </button>
          </div>
        </div>
      `;
      
      modal.classList.remove('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('refundModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeRefundModal();
      }
    });
  </script>
</x-layouts.app>