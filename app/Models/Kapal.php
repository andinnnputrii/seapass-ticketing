<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kapal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kapals';
    protected $primaryKey = 'kapal_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kapal_id',
        'nama_kapal',
        'jenis_kapal',
        'operator_id',
        'kapasitas',
        'pelabuhan_asal',
        'rute_aktif',
        'tanggal_registrasi',
        'status_operasional',
        'status_kebersihan',
        'foto_kapal',
        'keterangan_tambahan',
        'nomor_registrasi',
        'tahun_pembuatan',
        'panjang_kapal',
        'lebar_kapal'
    ];

    protected $casts = [
        'tanggal_registrasi' => 'date',
        'tahun_pembuatan' => 'integer',
        'panjang_kapal' => 'decimal:2',
        'lebar_kapal' => 'decimal:2'
    ];

    // Relasi
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'operator_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kapal_id', 'kapal_id');
    }

    // Scope untuk kapal yang beroperasi
    public function scopeBeroperasi($query)
    {
        return $query->where('status_operasional', 'Beroperasi');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'kapal_id', 'kapal_id');
    }
}
