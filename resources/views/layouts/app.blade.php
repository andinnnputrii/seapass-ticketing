<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
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
    body {
      font-family: "Inter", sans-serif;
      font-size: 0.95rem;
      line-height: 1.5;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    #app-shell {
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header fixed di atas */
    header {
      height: 64px;
      flex-shrink: 0;
      z-index: 50;
    }

    /* Container untuk sidebar dan konten */
    .content-wrapper {
      flex: 1;
      display: flex;
      overflow: hidden;
      height: calc(100vh - 64px);
    }

    /* Sidebar fixed */
    .sidebar {
      width: 260px;
      flex-shrink: 0;
      overflow-y: auto;
      transition: width 0.3s ease;
    }

    #app-shell.is-collapsed .sidebar {
      width: 72px;
    }

    /* Main content area yang bisa scroll */
    .main-content {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
    }

    main {
      max-width: 1920px;
      margin-inline: auto;
      width: 100%;
      box-sizing: border-box;
    }

    /* Sidebar label animations */
    #app-shell .sidebar .label {
      display: inline;
      transition: opacity 0.2s ease;
    }

    #app-shell.is-collapsed .sidebar .label {
      display: none;
    }

    /* Custom scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
      width: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
      background-color: #cbd5e1;
      border-radius: 10px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
      background-color: transparent;
    }
  </style>

  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
<div id="app-shell">

  {{-- Navbar Fixed --}}
  <header class="bg-brand-800 text-white px-4 lg:px-6 flex items-center justify-between shadow-md">
    <div class="flex items-center gap-4">
      <button id="sidebarToggle" class="p-2 rounded-md hover:bg-brand-700 transition-colors" aria-label="Toggle sidebar">
        <i data-feather="menu" class="w-5 h-5"></i>
      </button>

      {{-- Logo dengan link ke dashboard --}}
      <a href="{{ route('dashboard') }}" class="flex items-center hover:opacity-80 transition-opacity">
        <img src="{{ asset('images/logo.png') }}" alt="SeaPass Logo" class="h-10 object-contain">
      </a>
    </div>

    <div class="flex items-center gap-3">
      <select class="bg-brand-700 text-white text-sm rounded-md px-3 py-1.5 border-none outline-none cursor-pointer hover:bg-brand-600 transition-colors">
        <option>Indonesia</option>
        <option>English</option>
      </select>
      <button class="p-2 rounded-md hover:bg-brand-700 transition-colors relative">
        <i data-feather="bell" class="w-5 h-5"></i>
        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
      </button>
      <div class="flex items-center gap-2 pl-3 border-l border-brand-700">
        <span class="text-sm font-medium hidden lg:inline">Brodie</span>
        <div class="w-9 h-9 rounded-full bg-white/20 grid place-items-center font-semibold text-sm">OP</div>
      </div>
    </div>
  </header>

  {{-- Content Wrapper --}}
  <div class="content-wrapper">
    @php
      use Illuminate\Support\Str;
      $current = request()->route()->getName();
      $items = [
        ['label'=>'Dashboard','icon'=>'grid','route'=>route('dashboard'),'name'=>'dashboard'],
        ['label'=>'Kapal & Operator','icon'=>'anchor','route'=>route('kapal-operator.index'),'name'=>'kapal-operator.index'],
        ['label'=>'Jadwal Kapal','icon'=>'calendar','route'=>route('jadwal-kapal.index'),'name'=>'jadwal-kapal.index'],
        ['label'=>'Tiket & Validasi','icon'=>'file-text','route'=>route('tiket-validasi.index'),'name'=>'tiket-validasi.index'],
        ['label'=>'Data Penumpang','icon'=>'users','route'=>route('penumpang.index'),'name'=>'penumpang.index'],        ['label'=>'Transaksi & Refund','icon'=>'credit-card','route'=>route('admin.transactions.index'),'name'=>'admin.transactions.index'],
        ['label'=>'Laporan & Analitik','icon'=>'bar-chart-2','route'=>route('admin.reports.index'),'name'=>'admin.reports.index'],
        ['label'=>'Pengguna & Akses','icon'=>'shield','route'=>route('admin.users.index'),'name'=>'admin.users.index'],
        ['label'=>'Pengaduan','icon'=>'message-square','route'=>'#','name'=>'pengaduan'],
        ['label'=>'Pengaturan Sistem','icon'=>'settings','route'=>'#','name'=>'pengaturan'],
      ];
    @endphp

    {{-- Sidebar --}}
    <aside class="sidebar bg-white border-r border-slate-200 scrollbar-thin">
      <nav class="p-3">
        <ul class="space-y-1">
          @foreach($items as $item)
            @php $active = $current === $item['name']; @endphp
            <li>
              <a href="{{ $item['route'] }}"
                 class="flex items-center gap-3 px-3 py-2 rounded-md text-sm transition
                        {{ $active ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                <i data-feather="{{ $item['icon'] }}" class="w-4 h-4 shrink-0"></i>
                <span class="label">{{ $item['label'] }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </nav>
    </aside>

    {{-- Main Content yang bisa scroll --}}
    <div class="main-content bg-slate-50 scrollbar-thin">
      <main class="p-4 lg:p-6">
        @yield('content')
      </main>
    </div>
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

  if (window.Chart) Chart.defaults.animation = false;
</script>

@stack('scripts')
</body>
</html>
