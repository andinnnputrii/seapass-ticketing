@props([
  'title' => '',
  'value' => '',
  'suffix' => '',
  'note' => '',
  'noteColor' => 'text-emerald-600',
  'bg' => 'bg-white',
])

<div class="{{ $bg }} border border-slate-200 rounded-lg p-4">
  <div class="text-sm text-slate-500">{{ $title }}</div>
  <div class="mt-2 text-3xl font-semibold text-slate-900">
    {{ $value }} @if($suffix)<span class="text-base font-normal text-slate-500">{{ $suffix }}</span>@endif
  </div>
  @if($note)
    <div class="mt-3 flex items-center gap-2 text-xs {{ $noteColor }}">
      <i data-feather="trending-up" class="w-4 h-4"></i>
      <span>{{ $note }}</span>
    </div>
  @endif
</div>
