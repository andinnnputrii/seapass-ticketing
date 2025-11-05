<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiTiket extends Model
{
    protected $fillable = [
        'tiket_id',
        'waktu_validasi',
        'status_validasi',
        'metode',
        'lokasi_pintu',
        'petugas',
        'catatan'
    ];

    protected $casts = [
        'waktu_validasi' => 'datetime'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'tiket_id');
    }
}
