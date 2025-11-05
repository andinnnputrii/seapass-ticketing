@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-6 mt-6">
  <div class="flex items-center justify-between mb-5">
    <h2 class="text-2xl font-semibold text-slate-800">Tambah Operator</h2>
    <a href="{{ route('kapal-operator.index', ['view' => 'operator']) }}" class="text-slate-600 hover:text-blue-600 text-sm">← Kembali</a>
  </div>

  <form action="{{ route('operator.store') }}" method="POST" class="space-y-6">
    @csrf

    {{-- Nama Operator --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Nama Operator</label>
      <input type="text" name="nama_operator" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
    </div>

    {{-- Alamat Kantor --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Kantor</label>
      <textarea name="alamat_kantor" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2"></textarea>
    </div>

    {{-- Kontak --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Kontak</label>
      <input type="text" name="kontak" class="w-full border border-slate-300 rounded-lg px-3 py-2">
    </div>

    {{-- Email --}}
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
      <input type="email" name="email" class="w-full border border-slate-300 rounded-lg px-3 py-2">
    </div>

    <div class="flex justify-end mt-6">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Simpan Operator
      </button>
    </div>
  </form>
</div>
@endsection
