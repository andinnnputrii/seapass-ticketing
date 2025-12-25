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
        // 'id', // Primary key otomatis (bigint), tidak perlu diisi manual di fillable
        'jadwal_id',
        'penumpang_id',
        'kapal_id', // Opsional jika data kapal diambil via jadwal, tapi boleh ada untuk redundansi
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

    // PERBAIKAN: Relasi ke Transaction (Inggris)
    public function transaction()
    {
        // Transaction memiliki ticket_id yang mengarah ke id tiket ini
        return $this->hasOne(Transaction::class, 'ticket_id', 'id');
    }

    // Relasi ke Penumpang (Indo)
    public function penumpang()
    {
        return $this->belongsTo(
        Penumpang::class,
        'penumpang_id',   // FK di tabel tikets
        'penumpang_id'    // PK di tabel penumpangs
        );
    }


    // Relasi ke Jadwal (Indo)
    public function jadwal()
    {
        // Asumsi primary key tabel jadwals adalah 'id_jadwal' atau 'id'
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    // Relasi ke Kapal (Indo)
    public function kapal()
    {
        // Asumsi primary key tabel kapals adalah 'kapal_id'
        return $this->belongsTo(Kapal::class, 'kapal_id', 'kapal_id');
    }

    // Relasi ke Validasi Tiket
    public function validasis()
    {
        return $this->hasMany(ValidasiTiket::class, 'tiket_id', 'id');
    }

    public function kendaraan()
    {
        return $this->hasOne(Kendaraan::class, 'tiket_id', 'id');
    }

    // --- SCOPES & ACCESSORS (TETAP SAMA SEPERTI KODE MU) ---

    public function scopeValid($query) { return $query->where('status_tiket', 'Valid'); }
    public function scopeTervalidasi($query) { return $query->where('status_tiket', 'Tervalidasi'); }
    public function scopePending($query) { return $query->where('status_tiket', 'Pending'); }
    public function scopeBatal($query) { return $query->where('status_tiket', 'Batal'); }
    public function scopeReschedule($query) { return $query->where('status_tiket', 'Reschedule'); }
    public function scopePenumpang($query) { return $query->where('tipe_tiket', 'Penumpang'); }
    public function scopeKendaraan($query) { return $query->where('tipe_tiket', 'Kendaraan'); }

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

    public function getStatusPembayaranBadgeAttribute()
    {
        $badges = [
            'Paid' => 'success',
            'Pending' => 'warning',
            'Refund' => 'danger'
        ];
        return $badges[$this->status_pembayaran] ?? 'secondary';
    }

    public function getHargaFormattedAttribute() { return 'Rp ' . number_format($this->harga, 0, ',', '.'); }
    public function getTotalBayarFormattedAttribute() { return 'Rp ' . number_format($this->total_bayar, 0, ',', '.'); }
}
