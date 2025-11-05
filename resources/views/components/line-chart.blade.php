@php $id = 'chart_'.Str::random(6); @endphp

<div class="bg-white border border-slate-200 rounded-lg p-4">
  <div class="flex items-center justify-between mb-2">
    <h3 class="font-semibold">Penjualan Tiket</h3>
    <select class="text-sm border border-slate-200 rounded-md px-2 py-1" id="month-select-{{ $id }}">
      <option value="Mei">Mei</option>
      <option value="Juni">Juni</option>
      <option value="Juli">Juli</option>
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

  const monthlyData = {
    labels: @json($labels),
    datasets: [
      {
        label: 'Express',
        data: @json($datasets['express'] ?? []),
        borderColor: '#f59e0b',
        backgroundColor: 'rgba(245,158,11,0.15)',
        tension: 0.35,
        pointRadius: 4,
        pointHoverRadius: 8,
        pointBackgroundColor: '#f59e0b',
        pointHoverBackgroundColor: '#f59e0b',
        pointBorderColor: '#fff',
        pointHoverBorderWidth: 3,
        pointHoverBorderColor: '#f59e0b',
        fill: true,
      },
      {
        label: 'Regular',
        data: @json($datasets['regular'] ?? []),
        borderColor: '#f43f5e',
        backgroundColor: 'rgba(244,63,94,0.15)',
        tension: 0.35,
        pointRadius: 4,
        pointHoverRadius: 8,
        pointBackgroundColor: '#f43f5e',
        pointHoverBackgroundColor: '#f43f5e',
        pointBorderColor: '#fff',
        pointHoverBorderWidth: 3,
        pointHoverBorderColor: '#f43f5e',
        fill: true,
      }
    ]
  };

  // efek shadow lembut saat hover (custom plugin)
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
            ctx.shadowBlur = 15;
            ctx.fillStyle = dataset.pointHoverBackgroundColor;
            ctx.beginPath();
            ctx.arc(point.x, point.y, 8, 0, 2 * Math.PI);
            ctx.fill();
            ctx.restore();
          }
        });
      });
    }
  };

  let chart = new Chart(ctx, {
    type: 'line',
    data: monthlyData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 400 },
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          mode: 'index',
          intersect: false,
          backgroundColor: '#1e293b',
          titleColor: '#fff',
          bodyColor: '#e2e8f0',
          borderWidth: 1,
          borderColor: '#334155',
          padding: 10,
          cornerRadius: 8,
          displayColors: true
        }
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        y: { grid: { color: 'rgba(148,163,184,0.2)' } },
        x: { grid: { display: false } }
      }
    },
    plugins: [glowPlugin]
  });
})();
</script>
@endpush
