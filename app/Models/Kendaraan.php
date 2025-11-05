<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'tiket_id',
        'plat_nomor',
        'jenis_kendaraan',
        'panjang',
        'muatan'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'tiket_id');
    }
}
