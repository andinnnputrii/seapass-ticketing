<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'SeaPass Dashboard' }}</title>

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#e6f7f6',
              100: '#ccefeb',
              600: '#0f766e',
              700: '#115e59',
              800: '#134e4a'
            },
            express: { DEFAULT: '#f59e0b' },  // amber-500
            regular: { DEFAULT: '#f43f5e' },  // rose-500
          },
          borderRadius: { lg: '0.75rem' }
        }
      }
    }
  </script>

  {{-- Icons & Chart.js --}}
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  {{-- gaya untuk sidebar collapsed dan override grid kolom --}}
  <style>
    @media (min-width: 1024px) {
      .app-grid { grid-template-columns: 260px 1fr; }
      body.sidebar-collapsed .app-grid { grid-template-columns: 72px 1fr; }
    }
    #sidebar { width: 260px; transition: width .3s ease; }
    body.sidebar-collapsed #sidebar { width: 72px; }
    body.sidebar-collapsed #sidebar .logo-text,
    body.sidebar-collapsed #sidebar .menu-label { display: none; }
  </style>
</head>
<body class="h-full bg-slate-50 text-slate-900">
  {{-- tambahkan class app-grid untuk dikontrol via CSS di atas --}}
  <div class="min-h-screen grid app-grid grid-cols-1 lg:grid-cols-[260px_1fr]">
    {{-- Sidebar --}}
    {{-- beri id="sidebar" agar bisa dikontrol lebarnya --}}
    <aside id="sidebar" class="bg-white border-r border-slate-200 transition-[width] duration-300 overflow-hidden">
      <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-200">
        <div class="w-8 h-8 rounded-md bg-brand-700 flex items-center justify-center text-white font-semibold">S</div>
        {{-- tandai teks logo agar bisa disembunyikan saat collapsed --}}
        <div class="font-semibold logo-text">SeaPass</div>
      </div>
      <nav>
        <ul>
          @foreach ($menuItems as $item)
            <li class="flex items-center gap-4 p-4 hover:bg-slate-100">
              <i data-feather="{{ $item['icon'] }}"></i>
              <span class="menu-label">{{ $item['label'] }}</span>
            </li>
          @endforeach
        </ul>
      </nav>
    </aside>

    {{-- Main --}}
    <div class="min-h-screen flex flex-col">
      {{-- Topbar --}}
      <header class="h-16 bg-brand-800 text-white px-4 lg:px-6 flex items-center justify-between">
        {{-- tambah tombol toggle sidebar --}}
        <div class="flex items-center gap-2">
          <button id="sidebarToggle" class="p-2 rounded-md hover:bg-brand-700" aria-label="Toggle sidebar">
            <i data-feather="menu"></i>
          </button>
          <span class="font-semibold">Dashboard</span>
        </div>
        {{-- tambah tombol logout --}}
        <div class="flex items-center gap-2">
          <button class="p-2 rounded-md hover:bg-brand-700" aria-label="Logout">
            <i data-feather="log-out"></i>
          </button>
        </div>
      </header>

      {{-- Content --}}
      <main class="p-4 lg:p-6">
        {{ $slot }}
      </main>
    </div>
  </div>

  {{-- inisialisasi toggle + simpan preferensi di localStorage; jalankan feather.replace setelah init --}}
  <script>
    (function () {
      const cls = 'sidebar-collapsed';
      if (localStorage.getItem('sidebar-collapsed') === '1') {
        document.body.classList.add(cls);
      }
      const btn = document.getElementById('sidebarToggle');
      if (btn) {
        btn.addEventListener('click', () => {
          document.body.classList.toggle(cls);
          const collapsed = document.body.classList.contains(cls);
          localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
        });
      }
      feather.replace();
    })();
  </script>
  @stack('scripts')
</body>
</html>
