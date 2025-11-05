<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';
    protected $primaryKey = 'operator_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'operator_id',
        'nama_operator',
        'alamat_kantor',
        'kontak',
        'email',
        'kapal_dikelola'
    ];

    public function kapals()
    {
        return $this->hasMany(Kapal::class, 'operator_id', 'operator_id');
    }
}
