<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_jadwal',
        'kapal_id',
        'pelabuhan_asal',
        'pelabuhan_tujuan',
        'jam_berangkat',
        'estimasi_kedatangan',
        'tanggal_keberangkatan',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'date',
    ];

    // Relasi
    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kapal_id', 'kapal_id');
    }

    public function logs()
    {
        return $this->hasMany(JadwalLog::class);
    }

    // Accessor untuk format waktu
    public function getJamBerangkatFormattedAttribute()
    {
        return Carbon::parse($this->jam_berangkat)->format('H:i');
    }

    public function getEstimasiKedatanganFormattedAttribute()
    {
        return Carbon::parse($this->estimasi_kedatangan)->format('H:i');
    }

    // Helper untuk mendapatkan jumlah jadwal per hari
    public static function countByDate($date)
    {
        return self::whereDate('tanggal_keberangkatan', $date)->count();
    }

    // Scope
    public function scopeOnTime($query)
    {
        return $query->where('status', 'On-Time');
    }

    public function scopeDelay($query)
    {
        return $query->where('status', 'Delay');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'jadwal_id', 'id');
    }
}
