@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Detail Log Jadwal</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('jadwal-kapal.index') }}">Jadwal Kapal</a></li>
                    <li class="breadcrumb-item active">Detail Log</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('jadwal-kapal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Jadwal Info Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-muted small">ID Jadwal</label>
                    <h5>{{ $jadwal->id_jadwal }}</h5>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Nama Kapal</label>
                    <h5>{{ $jadwal->kapal->nama_kapal }}</h5>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Rute</label>
                    <h5>{{ $jadwal->pelabuhan_asal }} - {{ $jadwal->pelabuhan_tujuan }}</h5>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Status</label>
                    <h5>
                        <span class="badge bg-{{ $jadwal->status == 'On-Time' ? 'success' : ($jadwal->status == 'Delay' ? 'warning' : 'danger') }}">
                            {{ $jadwal->status }}
                        </span>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Log -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Riwayat Perubahan</h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                @forelse($logs as $log)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-{{ $log->jenis_perubahan_badge }}">
                            <i class="fas fa-{{ $log->jenis_perubahan == 'created' ? 'plus' : ($log->jenis_perubahan == 'deleted' ? 'trash' : 'edit') }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-{{ $log->jenis_perubahan_badge }} me-2">
                                        {{ $log->jenis_perubahan_text }}
                                    </span>
                                    <span class="text-muted small">
                                        {{ $log->created_at->format('d F Y, H:i:s') }}
                                    </span>
                                </div>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user"></i> {{ $log->diubah_oleh }}
                                </span>
                            </div>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-2"><strong>Perubahan:</strong></p>
                                    <p class="mb-2">{{ $log->perubahan }}</p>
                                    @if($log->alasan_perubahan)
                                        <hr class="my-2">
                                        <p class="mb-0 text-muted small">
                                            <strong>Alasan:</strong> {{ $log->alasan_perubahan }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada riwayat perubahan</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 50px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    z-index: 1;
}

.timeline-content {
    padding-left: 20px;
}
</style>
@endsection
