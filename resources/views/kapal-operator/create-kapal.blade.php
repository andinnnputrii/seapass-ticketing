@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
      <div class="bg-teal-100 p-2 rounded-lg">
        <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
      </div>
      <h2 class="text-xl font-bold text-slate-800">Tambah Kapal</h2>
    </div>

    {{-- Form --}}
    <form action="{{ route('kapal-operator.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Kapal ID --}}
        <div>
          <label for="kapal_id" class="block text-sm font-medium text-slate-700 mb-2">
            Kapal_id
          </label>
          <input type="text"
                 name="kapal_id"
                 id="kapal_id"
                 value="{{ old('kapal_id') }}"
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('kapal_id') border-red-500 @enderror"
                 placeholder="Auto generate">
          @error('kapal_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nama Kapal --}}
        <div>
          <label for="nama_kapal" class="block text-sm font-medium text-slate-700 mb-2">
            Nama Kapal
          </label>
          <input type="text"
                 name="nama_kapal"
                 id="nama_kapal"
                 value="{{ old('nama_kapal') }}"
                 required
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('nama_kapal') border-red-500 @enderror">
          @error('nama_kapal')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Jenis Kapal --}}
        <div>
          <label for="jenis_kapal" class="block text-sm font-medium text-slate-700 mb-2">
            Jenis Kapal
          </label>
          <input type="text"
                 name="jenis_kapal"
                 id="jenis_kapal"
                 value="{{ old('jenis_kapal') }}"
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('jenis_kapal') border-red-500 @enderror">
          @error('jenis_kapal')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Kapasitas --}}
        <div>
          <label for="kapasitas" class="block text-sm font-medium text-slate-700 mb-2">
            Kapasitas
          </label>
          <input type="number"
                 name="kapasitas"
                 id="kapasitas"
                 value="{{ old('kapasitas') }}"
                 required
                 min="0"
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('kapasitas') border-red-500 @enderror">
          @error('kapasitas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Pelabuhan Asal --}}
        <div>
          <label for="pelabuhan_asal" class="block text-sm font-medium text-slate-700 mb-2">
            Pelabuhan Asal
          </label>
          <input type="text"
                 name="pelabuhan_asal"
                 id="pelabuhan_asal"
                 value="{{ old('pelabuhan_asal') }}"
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('pelabuhan_asal') border-red-500 @enderror">
          @error('pelabuhan_asal')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Rute Aktif --}}
        <div>
          <label for="rute_aktif" class="block text-sm font-medium text-slate-700 mb-2">
            Rute Aktif
          </label>
          <input type="text"
                 name="rute_aktif"
                 id="rute_aktif"
                 value="{{ old('rute_aktif') }}"
                 class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('rute_aktif') border-red-500 @enderror">
          @error('rute_aktif')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Tanggal Registrasi --}}
        <div>
          <label for="tanggal_registrasi" class="block text-sm font-medium text-slate-700 mb-2">
            Tanggal Registrasi
          </label>
          <div class="relative">
            <input type="date"
                   name="tanggal_registrasi"
                   id="tanggal_registrasi"
                   value="{{ old('tanggal_registrasi') }}"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('tanggal_registrasi') border-red-500 @enderror">
            <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          @error('tanggal_registrasi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Status Operasional --}}
        <div>
          <label for="status_operasional" class="block text-sm font-medium text-slate-700 mb-2">
            Status Operasional
          </label>
          <select name="status_operasional"
                  id="status_operasional"
                  required
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('status_operasional') border-red-500 @enderror">
            <option value="">Pilih Status</option>
            <option value="Beroperasi" {{ old('status_operasional') == 'Beroperasi' ? 'selected' : '' }}>Beroperasi</option>
            <option value="Pemeliharaan" {{ old('status_operasional') == 'Pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
            <option value="Tidak Beroperasi" {{ old('status_operasional') == 'Tidak Beroperasi' ? 'selected' : '' }}>Tidak Beroperasi</option>
          </select>
          @error('status_operasional')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Status Kebisihan --}}
        <div>
          <label for="status_kebersihan" class="block text-sm font-medium text-slate-700 mb-2">
            Status Kebisihan
          </label>
          <select name="status_kebersihan"
                  id="status_kebersihan"
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('status_kebersihan') border-red-500 @enderror">
            <option value="">Pilih Status</option>
            <option value="Bersih" {{ old('status_kebersihan') == 'Bersih' ? 'selected' : '' }}>Bersih</option>
            <option value="Cukup Bersih" {{ old('status_kebersihan') == 'Cukup Bersih' ? 'selected' : '' }}>Cukup Bersih</option>
            <option value="Kotor" {{ old('status_kebersihan') == 'Kotor' ? 'selected' : '' }}>Kotor</option>
          </select>
          @error('status_kebersihan')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Operator --}}
        <div>
          <label for="operator_id" class="block text-sm font-medium text-slate-700 mb-2">
            Operator
          </label>
          <select name="operator_id"
                  id="operator_id"
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('operator_id') border-red-500 @enderror">
            <option value="">Pilih Operator</option>
            @foreach($operators as $operator)
              <option value="{{ $operator->operator_id }}" {{ old('operator_id') == $operator->operator_id ? 'selected' : '' }}>
                {{ $operator->nama_operator }}
              </option>
            @endforeach
          </select>
          @error('operator_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- Upload Foto Kapal --}}
      <div>
        <label for="foto_kapal" class="block text-sm font-medium text-slate-700 mb-2">
          Upload Foto Kapal
        </label>
        <input type="file"
               name="foto_kapal"
               id="foto_kapal"
               accept="image/jpeg,image/jpg,image/png"
               class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('foto_kapal') border-red-500 @enderror">
        <p class="mt-1 text-xs text-slate-500">
          **Upload gambar asset (format .cz) .png, .steker, .SMB .Garden.htm jpeg .aina, sive ke risau ksapacitian3Mim.k
        </p>
        @error('foto_kapal')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Keterangan Tambahan --}}
      <div>
        <label for="keterangan_tambahan" class="block text-sm font-medium text-slate-700 mb-2">
          Keterangan Tambahan
        </label>
        <textarea name="keterangan_tambahan"
                  id="keterangan_tambahan"
                  rows="3"
                  class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition @error('keterangan_tambahan') border-red-500 @enderror">{{ old('keterangan_tambahan') }}</textarea>
        @error('keterangan_tambahan')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('kapal-operator.index') }}"
           class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-all">
          Batal
        </a>
        <button type="submit"
                class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition-all shadow-sm">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
