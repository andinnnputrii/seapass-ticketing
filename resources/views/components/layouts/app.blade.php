{{-- Konsolidasikan layout menjadi komponen Blade. Memastikan {{ $slot }} dirender, tambah toggle sidebar & persist state --}}
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'SeaPass Dashboard' }}</title>

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
            express: { DEFAULT: '#f59e0b' },
            regular: { DEFAULT: '#f43f5e' },
          },
          borderRadius: { lg: '0.75rem' }
        }
      }
    }
  </script>
  <style>
    /* atur kolom grid saat collapsed */
    #app-shell { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
    #app-shell.is-collapsed { grid-template-columns: 72px 1fr; }
    #app-shell .sidebar .label { display: inline; }
    #app-shell.is-collapsed .sidebar .label { display: none; }
    #app-shell.is-collapsed .sidebar .logo-text { display: none; }
  </style>

  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body class="h-full bg-slate-50 text-slate-900">

  <div id="app-shell">
    {{-- Sidebar --}}
    <aside class="sidebar bg-white border-r border-slate-200">
      <div class="h-16 flex items-center gap-3 px-4 border-b border-slate-200">
        <div class="w-8 h-8 rounded-md bg-brand-700 flex items-center justify-center text-white font-semibold">S</div>
        <div class="font-semibold logo-text">SeaPass</div>
      </div>

      @php
        $items = $menuItems ?? [
          ['label'=>'Dashboard','icon'=>'grid','route'=>route('dashboard')],
          ['label'=>'Kapal & Operator','icon'=>'anchor','route'=>'#'],
          ['label'=>'Jadwal Kapal','icon'=>'calendar','route'=>'#'],
          ['label'=>'Tiket & Validasi','icon'=>'ticket','route'=>'#'],
          ['label'=>'Data Penumpang','icon'=>'users','route'=>'#'],
          ['label'=>'Transaksi & Refund','icon'=>'credit-card','route'=>'#'],
          ['label'=>'Laporan & Analitik','icon'=>'bar-chart-2','route'=>'#'],
          ['label'=>'Pengguna & Akses','icon'=>'shield','route'=>'#'],
          ['label'=>'Pengaduan','icon'=>'message-square','route'=>'#'],
          ['label'=>'Pengaturan Sistem','icon'=>'settings','route'=>'#'],
        ];
        $current = url()->current();
      @endphp

      <nav class="p-3">
        <ul class="space-y-1">
          @foreach($items as $item)
            @php $active = $current === $item['route']; @endphp
            <li>
              <a href="{{ $item['route'] }}"
                 class="flex items-center gap-3 px-3 py-2 rounded-md text-sm transition
                        {{ $active ? 'bg-brand-50 text-brand-700' : 'hover:bg-slate-100' }}">
                <i data-feather="{{ $item['icon'] }}" class="w-4 h-4"></i>
                <span class="label">{{ $item['label'] }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </nav>
    </aside>

    {{-- Main --}}
    <div class="min-h-screen flex flex-col">
      {{-- Topbar --}}
      <header class="h-16 bg-brand-800 text-white px-4 lg:px-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button id="sidebarToggle" class="p-2 rounded-md hover:bg-brand-700" aria-label="Toggle sidebar">
            <i data-feather="menu"></i>
          </button>
          <div class="font-semibold">Dashboard</div>
        </div>
        <div class="flex items-center gap-3">
          <select class="bg-brand-700 text-white text-sm rounded-md px-2 py-1" aria-label="Bahasa">
            <option>Indonesia</option>
            <option>English</option>
          </select>
          <button class="p-2 rounded-md hover:bg-brand-700" aria-label="Notifikasi"><i data-feather="bell"></i></button>
          <div class="flex items-center gap-2">
            <span class="text-sm opacity-90">Brodie</span>
            <div class="w-8 h-8 rounded-full bg-white/20 grid place-items-center">OP</div>
          </div>
        </div>
      </header>

      {{-- Content --}}
      <main class="p-4 lg:p-6">
        {{ $slot }}
      </main>
    </div>
  </div>

  <script>
    feather.replace();

    (() => {
      const KEY = 'sidebar:collapsed';
      const shell = document.getElementById('app-shell');
      const btn = document.getElementById('sidebarToggle');

      const setState = (collapsed) => {
        if (collapsed) shell.classList.add('is-collapsed');
        else shell.classList.remove('is-collapsed');
        localStorage.setItem(KEY, collapsed ? '1' : '0');
      };

      const initial = localStorage.getItem(KEY) === '1';
      setState(initial);

      btn?.addEventListener('click', () => {
        const now = !shell.classList.contains('is-collapsed');
        setState(now);
      });
    })();

    if (window.Chart) {
      Chart.defaults.animation = false;
    }
  </script>

  @stack('scripts')
</body>
</html>
