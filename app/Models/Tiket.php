<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tiket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tikets';

    protected $fillable = [
        'tiket_id',
        'penumpang_id',
        'jadwal_id',
        'kapal_id',
        'tipe_tiket',
        'kelas_tiket',
        'harga',
        'pajak',
        'total_bayar',
        'metode_bayar',
        'status_pembayaran',
        'status_tiket',
        'kode_booking',
        'nomor_kursi',
        'nomor_kendaraan',
        'waktu_pemesanan',
        'waktu_pembayaran',
        'waktu_validasi',
        'validasi_oleh',
        'catatan'
    ];

    protected $casts = [
        'waktu_pemesanan' => 'datetime',
        'waktu_pembayaran' => 'datetime',
        'waktu_validasi' => 'datetime',
        'harga' => 'decimal:2',
        'pajak' => 'decimal:2',
        'total_bayar' => 'decimal:2'
    ];

    // Relasi ke Penumpang
    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'penumpang_id', 'penumpang_id');
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }

    // Relasi ke Kapal
    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kapal_id', 'kapal_id');
    }

    // Relasi ke Validasi Tiket
    public function validasis()
    {
        return $this->hasMany(ValidasiTiket::class, 'tiket_id', 'id');
    }

    public function kendaraan()
    {
        return $this->hasOne(Kendaraan::class, 'tiket_id', 'tiket_id');
    }

    // Scope untuk filter status tiket
    public function scopeValid($query)
    {
        return $query->where('status_tiket', 'Valid');
    }

    public function scopeTervalidasi($query)
    {
        return $query->where('status_tiket', 'Tervalidasi');
    }

    public function scopePending($query)
    {
        return $query->where('status_tiket', 'Pending');
    }

    public function scopeBatal($query)
    {
        return $query->where('status_tiket', 'Batal');
    }

    public function scopeReschedule($query)
    {
        return $query->where('status_tiket', 'Reschedule');
    }

    // Scope untuk filter tipe tiket
    public function scopePenumpang($query)
    {
        return $query->where('tipe_tiket', 'Penumpang');
    }

    public function scopeKendaraan($query)
    {
        return $query->where('tipe_tiket', 'Kendaraan');
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Valid' => 'success',
            'Batal' => 'danger',
            'Tervalidasi' => 'info',
            'Reschedule' => 'warning',
            'Pending' => 'secondary'
        ];
        return $badges[$this->status_tiket] ?? 'secondary';
    }

    // Accessor untuk badge pembayaran
    public function getStatusPembayaranBadgeAttribute()
    {
        $badges = [
            'Paid' => 'success',
            'Pending' => 'warning',
            'Refund' => 'danger'
        ];
        return $badges[$this->status_pembayaran] ?? 'secondary';
    }

    // Accessor untuk format harga
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getTotalBayarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }
}
