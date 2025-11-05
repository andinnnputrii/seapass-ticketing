@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Edit Kapal & Operator</h2>
                <a href="{{ route('kapal-operator.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kapal-operator.update', $kapal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Informasi Kapal</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kapal <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kapal" class="form-control @error('nama_kapal') is-invalid @enderror"
                                       value="{{ old('nama_kapal', $kapal->nama_kapal) }}" required>
                                @error('nama_kapal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Operator <span class="text-danger">*</span></label>
                                <select name="operator_id" class="form-select @error('operator_id') is-invalid @enderror" required>
                                    <option value="">Pilih Operator</option>
                                    @foreach($operators as $operator)
                                        <option value="{{ $operator->id }}"
                                                {{ old('operator_id', $kapal->operator_id) == $operator->id ? 'selected' : '' }}>
                                            {{ $operator->nama_operator }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('operator_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kapal</label>
                                <input type="text" name="jenis_kapal" class="form-control @error('jenis_kapal') is-invalid @enderror"
                                       value="{{ old('jenis_kapal', $kapal->jenis_kapal) }}" placeholder="Contoh: Tanker, Cargo, dll">
                                @error('jenis_kapal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Call Sign</label>
                                <input type="text" name="call_sign" class="form-control @error('call_sign') is-invalid @enderror"
                                       value="{{ old('call_sign', $kapal->call_sign) }}">
                                @error('call_sign')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">GT (Gross Tonnage)</label>
                                <input type="number" name="gt" class="form-control @error('gt') is-invalid @enderror"
                                       value="{{ old('gt', $kapal->gt) }}" step="0.01">
                                @error('gt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">LOA (Length Overall)</label>
                                <input type="number" name="loa" class="form-control @error('loa') is-invalid @enderror"
                                       value="{{ old('loa', $kapal->loa) }}" step="0.01" placeholder="Meter">
                                @error('loa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="aktif" {{ old('status', $kapal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ old('status', $kapal->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                          rows="3">{{ old('keterangan', $kapal->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kapal-operator.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
