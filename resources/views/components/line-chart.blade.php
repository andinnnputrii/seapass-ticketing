@php $id = 'chart_'.Str::random(6); @endphp

<div class="bg-white border border-slate-200 rounded-lg p-4">
  <div class="flex items-center justify-between mb-2">
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
