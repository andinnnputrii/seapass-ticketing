<x-layouts.app :title="'Pengguna & Akses'">
  <!-- Header -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-800">Pengguna & Akses</h1>
      <p class="text-sm text-gray-600 mt-1">Kelola pengguna internal (Admin & Operator) dan pelanggan terdaftar</p>
    </div>
    
    <!-- Action Buttons -->
    <div class="mt-4 lg:mt-0 flex gap-2">
      <button onclick="exportUsers()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        Export
      </button>
      <button onclick="openAddUserModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah User
      </button>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
      <div class="flex items-center gap-3">
        <div class="p-3 bg-blue-50 rounded-lg">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <div>
          <p class="text-sm text-gray-600">Total Tim Internal</p>
          <p class="text-2xl font-bold text-gray-900">{{ $totalAdmins }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
      <div class="flex items-center gap-3">
        <div class="p-3 bg-purple-50 rounded-lg">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
        </div>
        <div>
          <p class="text-sm text-gray-600">Total Pelanggan</p>
          <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
      <div class="flex items-center gap-3">
        <div class="p-3 bg-orange-50 rounded-lg">
          <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div>
          <p class="text-sm text-gray-600">User Aktif Hari Ini</p>
          <p class="text-2xl font-bold text-gray-900">{{ $activeToday }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <!-- Tabs -->
    <div class="border-b border-gray-200">
      <nav class="flex -mb-px">
        <a href="{{ route('admin.users.index', ['tab' => 'internal']) }}" 
           class="px-6 py-4 text-sm font-medium border-b-2 flex items-center gap-2 {{ $tab === 'internal' ? 'border-teal-600 text-teal-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
          Tim Internal ({{ $totalAdmins + $totalOperators }})
        </a>
        <a href="{{ route('admin.users.index', ['tab' => 'customers']) }}" 
           class="px-6 py-4 text-sm font-medium border-b-2 flex items-center gap-2 {{ $tab === 'customers' ? 'border-teal-600 text-teal-600' : 'border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300' }}">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          Pelanggan ({{ $totalCustomers }})
        </a>
      </nav>
    </div>

    <!-- Filters & Search -->
    <div class="p-4 border-b border-gray-200 bg-gray-50">
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-3">
        <input type="hidden" name="tab" value="{{ $tab }}">
        
        <!-- Search -->
        <div class="flex-1 min-w-[250px]">
          <div class="relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input 
              type="text" 
              name="search" 
              value="{{ request('search') }}"
              placeholder="Cari nama, email, {{ $tab === 'internal' ? 'atau ID user' : 'atau nomor telepon' }}..." 
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            >
          </div>
        </div>

        @if($tab === 'internal')
          <!-- Filter Role -->
          <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="operator" {{ request('role') === 'operator' ? 'selected' : '' }}>Operator</option>
          </select>
        @endif

        <!-- Filter Status -->
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
          <option value="">Semua Status</option>
          @if($tab === 'internal')
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-aktif</option>
          @else
            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
          @endif
        </select>

        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">
          Filter
        </button>
        <a href="{{ route('admin.users.index', ['tab' => $tab]) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
          Reset
        </a>
      </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="px-4 py-3 text-left">
              <input type="checkbox" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
            </th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
              {{ $tab === 'internal' ? 'ID' : 'PELANGGAN' }}
            </th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
              {{ $tab === 'internal' ? 'NAMA & EMAIL' : 'KONTAK' }}
            </th>
            @if($tab === 'internal')
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ROLE</th>
            @else
              <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">TOTAL TRIP</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">BERGABUNG</th>
            @endif
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STATUS</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">LAST LOGIN</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">DIBUAT</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">AKSI</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
              <td class="px-4 py-4">
                <input type="checkbox" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
              </td>
              
              @if($tab === 'internal')
                <!-- Internal User -->
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-medium text-gray-900">{{ $user->username ?? 'USR'.str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white font-semibold text-sm">
                      {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                      <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                      <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-3 py-1 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      @if($user->role === 'admin')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                      @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                      @endif
                    </svg>
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
              @else
                <!-- Customer -->
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                      {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                      <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                      <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-gray-700">{{ $user->phone ?? '-' }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <span class="px-3 py-1 text-sm font-bold bg-blue-100 text-blue-800 rounded-full">
                    {{ $user->total_trips }} Trip
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-gray-700">{{ $user->created_at->format('d M Y') }}</span>
                </td>
              @endif

              <!-- Status -->
              <td class="px-6 py-4 whitespace-nowrap">
                @if($tab === 'internal')
                  <span class="px-3 py-1 text-xs font-medium rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    ● {{ ucfirst($user->status) }}
                  </span>
                @else
                  @if($user->status === 'verified')
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">✓ Verified</span>
                  @elseif($user->status === 'unverified')
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">⚠ Unverified</span>
                  @else
                    <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">⚠ Suspended</span>
                  @endif
                @endif
              </td>

              <!-- Last Login -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-gray-700">
                  {{ $user->last_login ? $user->last_login->diffForHumans() : '-' }}
                </span>
              </td>

              <!-- Created At -->
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-gray-700">{{ $user->created_at->format('d M Y') }}</span>
              </td>

              <!-- Actions -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center gap-2">
                  <button onclick="viewUser('{{ $tab }}', {{ $user->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                  </button>
                  <button onclick="editUser('{{ $tab }}', {{ $user->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                  </button>
                  <button onclick="resetPassword('{{ $tab }}', {{ $user->id }})" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition" title="Reset Password">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                  </button>
                  <button onclick="deleteUser('{{ $tab }}', {{ $user->id }}, '{{ $user->name }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-6 py-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="text-gray-500 font-medium">Tidak ada data user</p>
                <p class="text-sm text-gray-400 mt-1">User akan muncul di sini setelah ditambahkan</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
      <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <div class="text-sm text-gray-600">
          Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
        </div>
        <div class="flex gap-1">
          {{ $users->links() }}
        </div>
      </div>
    @endif
  </div>

  <!-- Modal: Add User -->
  <div id="addUserModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Tambah User Baru</h3>
          <button onclick="closeAddUserModal()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.users.store.internal') }}" class="p-6 space-y-4">
        @csrf
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
          <input type="text" name="username" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
          <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
          <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            <option value="admin">Admin</option>
            <option value="operator">Operator</option>
          </select>
        </div>
        <div class="flex gap-3 pt-4">
          <button type="submit" class="flex-1 px-4 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-medium transition">
            Simpan User
          </button>
          <button type="button" onclick="closeAddUserModal()" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition">
            Batal
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal: View User Detail -->
  <div id="viewUserModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Detail User</h3>
          <button onclick="closeViewUserModal()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
      <div id="viewUserContent" class="p-6">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
      {{ session('success') }}
    </div>
  @endif

  @push('scripts')
  <script>
    function openAddUserModal() {
      document.getElementById('addUserModal').classList.remove('hidden');
    }

    function closeAddUserModal() {
      document.getElementById('addUserModal').classList.add('hidden');
    }

    function closeViewUserModal() {
      document.getElementById('viewUserModal').classList.add('hidden');
    }

    async function viewUser(type, id) {
      try {
        const response = await fetch(`/admin/users/${type}/${id}`);
        const user = await response.json();
        
        const modal = document.getElementById('viewUserModal');
        const content = document.getElementById('viewUserContent');
        
        const isInternal = type === 'internal';
        
        content.innerHTML = `
          <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white font-bold text-xl">
              ${user.name.substring(0, 2).toUpperCase()}
            </div>
            <div>
              <h4 class="text-xl font-bold text-gray-900">${user.name}</h4>
              <p class="text-sm text-gray-500">${user.email}</p>
              ${isInternal ? `<span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full ${user.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800'}">${user.role}</span>` : ''}
            </div>
          </div>
          
          <div class="grid grid-cols-2 gap-4 mb-6">
            ${isInternal ? `
              <div>
                <p class="text-xs text-gray-500 mb-1">User ID</p>
                <p class="font-semibold text-gray-900">${user.username || 'USR' + user.id.toString().padStart(3, '0')}</p>
              </div>
            ` : `
              <div>
                <p class="text-xs text-gray-500 mb-1">Nomor Telepon</p>
                <p class="font-semibold text-gray-900">${user.phone || '-'}</p>
              </div>
              <div>
                <p class="text-xs text-gray-500 mb-1">Total Trip</p>
                <p class="font-semibold text-gray-900">${user.total_trips} perjalanan</p>
              </div>
            `}
            <div>
              <p class="text-xs text-gray-500 mb-1">Last Login</p>
              <p class="font-semibold text-gray-900">${user.last_login ? new Date(user.last_login).toLocaleString('id-ID') : 'Belum pernah login'}</p>
            </div>
            <div>
              <p class="text-xs text-gray-500 mb-1">Dibuat Pada</p>
              <p class="font-semibold text-gray-900">${new Date(user.created_at).toLocaleDateString('id-ID')}</p>
            </div>
          </div>

          ${isInternal ? `
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
              <h5 class="font-semibold text-gray-800 mb-3">Hak Akses & Permission</h5>
              <div class="grid grid-cols-3 gap-2">
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Dashboard</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Kapal & Operator</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Jadwal</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Tiket</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Penumpang</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Transaksi</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Laporan</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Pengguna</p>
                </div>
                <div class="text-center p-2 bg-white rounded border border-gray-200">
                  <p class="text-xs text-gray-600">Pengaturan</p>
                </div>
              </div>
            </div>
          ` : ''}

          <div class="flex gap-3 pt-4 border-t">
            <button onclick="editUser('${type}', ${id})" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
              Edit User
            </button>
            <button onclick="resetPassword('${type}', ${id})" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
              Reset Password
            </button>
            ${!isInternal || user.id !== {{ session('admin_id') }} ? `
              <button onclick="deleteUser('${type}', ${id}, '${user.name}')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Hapus
              </button>
            ` : ''}
          </div>
        `;
        
        modal.classList.remove('hidden');
      } catch (error) {
        alert('Gagal memuat detail user');
      }
    }

    function editUser(type, id) {
      // Implement edit functionality
      alert('Edit user functionality coming soon!');
    }

    function resetPassword(type, id) {
      const newPassword = prompt('Masukkan password baru (minimal 6 karakter):');
      if (newPassword && newPassword.length >= 6) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${type}/${id}/reset-password`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const pass = document.createElement('input');
        pass.type = 'hidden';
        pass.name = 'new_password';
        pass.value = newPassword;
        
        form.appendChild(csrf);
        form.appendChild(pass);
        document.body.appendChild(form);
        form.submit();
      }
    }

    function deleteUser(type, id, name) {
      if (confirm(`Yakin ingin menghapus user "${name}"? Tindakan ini tidak dapat dibatalkan.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${type}/${id}`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
      }
    }

    function exportUsers() {
      alert('Export functionality coming soon!');
    }

    // Auto-hide success message
    setTimeout(() => {
      const alert = document.querySelector('.fixed.bottom-4');
      if (alert) alert.remove();
    }, 3000);
  </script>
  @endpush
</x-layouts.app>