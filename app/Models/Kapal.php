<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kapal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kapals';

    // Primary Key
    protected $primaryKey = 'kapal_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kapal_id',
        'operator_id',
        'nama_kapal',
        'jenis_kapal',
        'kapasitas_penumpang',
        'kapasitas_kendaraan',
        'status_operasional',
        'deskripsi',
        'foto_url'
    ];

    public function scopeBeroperasi($query)
    {
        return $query->where('status_operasional', 'Beroperasi');
    }

    // Relasi ke Operator
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'operator_id');
    }

    // Relasi ke Jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'kapal_id', 'kapal_id');
    }

    // Relasi ke Tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'kapal_id', 'kapal_id');
    }
}
