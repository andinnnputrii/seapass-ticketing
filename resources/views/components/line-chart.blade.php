@php $id = 'chart_'.Str::random(6); @endphp

<div class="bg-white border border-slate-200 rounded-lg p-4">
  <div class="flex items-center justify-between mb-2"><<<<<<< HEAD
    <div class="flex items-center gap-3">
      <h3 class="font-semibold">Penjualan Tiket</h3>
      <!-- Breadcrumb untuk drill-down navigation -->
      <div id="breadcrumb-{{ $id }}" class="hidden text-sm text-slate-500">
        <span class="text-slate-300">/</span>
        <button class="text-amber-600 hover:text-amber-700 font-medium transition-colors" id="back-btn-{{ $id }}">
          <i data-feather="arrow-left" class="w-3 h-3 inline"></i> Kembali
        </button>
        <span class="text-slate-300 mx-1">/</span>
        <span id="current-day-{{ $id }}" class="font-medium text-slate-700"></span>
      </div>
    </div>
    <select class="text-sm border border-slate-200 rounded-md px-2 py-1" id="month-select-{{ $id }}">
      <option value="Mei">Mei</option>
      <option value="Juni">Juni</option>
      <option value="Juli">Juli</option>
    </select>
  </div>

  <!-- Info helper untuk user -->
  <div id="helper-{{ $id }}" class="mb-3 text-xs text-slate-500 bg-amber-50 border border-amber-200 rounded px-3 py-2 flex items-center gap-2">
    <i data-feather="info" class="w-3 h-3 text-amber-600"></i>
    <span> Klik pada titik data untuk melihat breakdown per periode waktu</span>
  </div>
    <h3 class="font-semibold">Penjualan Tiket</h3>
    <select class="text-sm border border-slate-200 rounded-md px-2 py-1">
      <option>Mei</option>
      <option>Juni</option>
      <option>Juli</option>
    </select>
  </div>
  <div style="height: {{ (int)$height }}px;">
    <canvas id="{{ $id }}"></canvas>
  </div>
</div>

@push('scripts')
<script>
(() => {
  const id = '{{ $id }}';
  const ctx = document.getElementById(id).getContext('2d');

  let currentView = 'overview'; // 'overview' atau 'detail'
  let selectedDay = null;

  // Data overview (harian - total Express + Regular)
  const expressData = @json($datasets['express'] ?? []);
  const regularData = @json($datasets['regular'] ?? []);

  const overviewData = {
    labels: @json($labels),
    datasets: [{
      label: 'Total Penjualan',
      data: expressData.map((val, i) => val + (regularData[i] || 0)),
      borderColor: '#3b82f6',
      backgroundColor: 'rgba(59,130,246,0.15)',
      tension: 0.35,
      pointRadius: 6,
      pointHoverRadius: 10,
      pointBackgroundColor: '#3b82f6',
      pointHoverBackgroundColor: '#3b82f6',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
      pointHoverBorderWidth: 3,
      pointHoverBorderColor: '#fff',
      fill: true,
    }]
  };

  // Data detail (breakdown Express vs Regular per periode waktu)
  const detailLabels = ['Pagi (06-10)', 'Siang (10-14)', 'Sore (14-18)', 'Malam (18-22)'];

  const detailData = {
    labels: detailLabels,
    datasets: [
      {
        label: 'Express',
        data: [],
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245,158,11,0.15)',
        tension: 0.35,
        pointRadius: 5,
        pointHoverRadius: 8,
        pointBackgroundColor: '#f59e0b',
        pointHoverBackgroundColor: '#f59e0b',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointHoverBorderWidth: 3,
        pointHoverBorderColor: '#fff',
        fill: true,
      },
      {
        label: 'Regular',
        data: [],
        borderColor: '#f43f5e',
        backgroundColor: 'rgba(244,63,94,0.15)',
        tension: 0.35,
        pointRadius: 5,
        pointHoverRadius: 8,
        pointBackgroundColor: '#f43f5e',
        pointHoverBackgroundColor: '#f43f5e',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointHoverBorderWidth: 3,
        pointHoverBorderColor: '#fff',
        fill: true,
  const el = document.getElementById('{{ $id }}');
  if (!el) return;

  const ctx = el.getContext('2d');
  const data = {
    labels: @json($labels),
    datasets: [
      {
        label: 'Express',
        data: @json($datasets['express'] ?? []),
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245, 158, 11, 0.15)',
        tension: 0.35,
        pointRadius: 3
      },
      {
        label: 'Regular',
        data: @json($datasets['regular'] ?? []),
        borderColor: '#f43f5e',
        backgroundColor: 'rgba(244, 63, 94, 0.15)',
        tension: 0.35,
        pointRadius: 3
      }
    ]
  };

  // Data breakdown dari controller
  const weeklyBreakdown = @json($weeklyBreakdown ?? []);

  // Plugin untuk glow effect
  const glowPlugin = {
    id: 'glowEffect',
    afterDraw(chart, args, options) {
      const ctx = chart.ctx;
      chart.data.datasets.forEach((dataset, i) => {
        const meta = chart.getDatasetMeta(i);
        meta.data.forEach(point => {
          if (point.active) {
            ctx.save();
            ctx.shadowColor = dataset.borderColor;
            ctx.shadowBlur = 20;
            ctx.fillStyle = dataset.pointHoverBackgroundColor;
            ctx.beginPath();
            ctx.arc(point.x, point.y, point.options.radius, 0, 2 * Math.PI);
            ctx.fill();
            ctx.restore();
          }
        });
      });
    }
  };

  let chart = new Chart(ctx, {
    type: 'line',
    data: overviewData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 600, easing: 'easeInOutQuart' },
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            usePointStyle: true,
            padding: 15,
            font: { size: 12 }
          }
        },
        tooltip: {
          mode: 'index',
          intersect: false,
          backgroundColor: '#1e293b',
          titleColor: '#fff',
          bodyColor: '#e2e8f0',
          borderWidth: 1,
          borderColor: '#334155',
          padding: 12,
          cornerRadius: 8,
          displayColors: true,
          callbacks: {
            footer: (items) => {
              if (currentView === 'overview') {
                return '\n Klik untuk detail per periode';
              }
              return '';
            }
          }
        }
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        y: {
          grid: { color: 'rgba(148,163,184,0.2)' },
          beginAtZero: true,
          ticks: { font: { size: 11 } }
        },
        x: {
          grid: { display: false },
          ticks: { font: { size: 11 } }
        }
      },
      onClick: (event, elements) => {
        if (currentView === 'overview' && elements.length > 0) {
          const index = elements[0].index;
          const dayLabel = overviewData.labels[index];
          drillDown(index, dayLabel);
        }
      },
      onHover: (event, elements) => {
        event.native.target.style.cursor = (currentView === 'overview' && elements.length > 0) ? 'pointer' : 'default';
      }
    },
    plugins: [glowPlugin]
  });

  // Fungsi drill-down
  function drillDown(index, dayLabel) {
    currentView = 'detail';
    selectedDay = index;

    // Ambil data breakdown untuk hari yang diklik
    const breakdown = weeklyBreakdown[index];

    if (breakdown) {
      detailData.datasets[0].data = breakdown.express;
      detailData.datasets[1].data = breakdown.regular;
    } else {
      // Fallback jika data tidak ada
      detailData.datasets[0].data = [0, 0, 0, 0];
      detailData.datasets[1].data = [0, 0, 0, 0];
    }

    // Update chart dengan animasi
    chart.data = detailData;
    chart.options.animation.duration = 600;
    chart.update();

    // Update UI
    document.getElementById('breadcrumb-' + id).classList.remove('hidden');
    document.getElementById('current-day-' + id).textContent = 'Hari ke-' + dayLabel;
    document.getElementById('helper-' + id).classList.add('hidden');
  }

  // Fungsi kembali ke overview
  function backToOverview() {
    currentView = 'overview';
    selectedDay = null;

    chart.data = overviewData;
    chart.options.animation.duration = 600;
    chart.update();

    // Update UI
    document.getElementById('breadcrumb-' + id).classList.add('hidden');
    document.getElementById('helper-' + id).classList.remove('hidden');
  }

  // Event listener untuk tombol back
  document.getElementById('back-btn-' + id).addEventListener('click', backToOverview);

  // Re-initialize Feather icons jika sudah di-load
  if (typeof feather !== 'undefined') {
    feather.replace();
  }
  new Chart(ctx, {
    type: 'line',
    data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false, // hentikan animasi agar tidak bergerak terus
      plugins: {
        legend: { position: 'bottom' },
        tooltip: { mode: 'index', intersect: false }
      },
      scales: {
        y: { grid: { color: 'rgba(148,163,184,0.2)' } },
        x: { grid: { display: false } }
      }
    }
  });
})();
</script>
@endpush
