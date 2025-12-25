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

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'penumpang_id', 'penumpang_id');
    }

    public function latestTiket()
    {
        return $this->hasOne(Tiket::class, 'penumpang_id', 'penumpang_id')
            ->latest('created_at');
    }

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->age;
        }
        return null;
    }

    public function getJenisKelaminShortAttribute()
    {
        return $this->jenis_kelamin === 'Laki-laki' ? 'L' : 'P';
    }

    public function scopeJenisKelamin($query, $jenisKelamin)
    {
        if ($jenisKelamin) {
            return $query->where('jenis_kelamin', $jenisKelamin);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }
}
