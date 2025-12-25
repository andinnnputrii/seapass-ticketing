<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jadwals';

    /**
     * Primary Key
     */
    protected $primaryKey = 'id_jadwal';
    public $incrementing = false;
    protected $keyType = 'string';

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

    public function kapal()
    {
        return $this->belongsTo(Kapal::class, 'kapal_id', 'kapal_id');
    }

    public function logs()
    {
        return $this->hasMany(JadwalLog::class, 'id_jadwal', 'id_jadwal');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'jadwal_id', 'id_jadwal');
    }

    public function getJamBerangkatFormattedAttribute()
    {
        return Carbon::parse($this->jam_berangkat)->format('H:i');
    }

    public function getEstimasiKedatanganFormattedAttribute()
    {
        return Carbon::parse($this->estimasi_kedatangan)->format('H:i');
    }

    public static function countByDate($date)
    {
        return self::whereDate('tanggal_keberangkatan', $date)->count();
    }

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
}
