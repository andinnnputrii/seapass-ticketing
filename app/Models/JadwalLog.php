<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'id_jadwal',
        'kapal_id',
        'nama_kapal',
        'perubahan',
        'diubah_oleh',
        'alasan_perubahan',
        'jenis_perubahan'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    // Relasi
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kapal_id', 'kapal_id');
    }

    // Accessor untuk badge jenis perubahan
    public function getJenisPerubahanBadgeAttribute()
    {
        $badges = [
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            'status_changed' => 'warning'
        ];

        return $badges[$this->jenis_perubahan] ?? 'secondary';
    }

    public function getJenisPerubahanTextAttribute()
    {
        $texts = [
            'created' => 'Dibuat',
            'updated' => 'Diperbarui',
            'deleted' => 'Dihapus',
            'status_changed' => 'Status Berubah'
        ];

        return $texts[$this->jenis_perubahan] ?? $this->jenis_perubahan;
    }

    // Scope
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByKapal($query, $kapalId)
    {
        return $query->where('kapal_id', $kapalId);
    }

    public function scopeByUser($query, $user)
    {
        return $query->where('diubah_oleh', $user);
    }
}
