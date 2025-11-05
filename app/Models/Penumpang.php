<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penumpang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penumpangs';
    protected $primaryKey = 'penumpang_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penumpang_id',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telepon',
        'email',
        'alamat'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relasi ke Tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'penumpang_id', 'penumpang_id');
    }

    // Accessor
    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->age;
        }
        return null;
    }
}
