<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';

    // Karena di SQL operator_id adalah VARCHAR (string), kita harus set ini:
    protected $primaryKey = 'operator_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'operator_id',
        'nama_operator',
        'alamat_kantor',
        'kontak',
        'email',
        // 'kapal_dikelola' // Biasanya ini tidak perlu di fillable jika hanya relasi, tapi ok jika ada kolomnya.
    ];

    // Relasi ke Kapals (Indo)
    public function kapals()
    {
        // Operator punya banyak Kapal
        return $this->hasMany(Kapal::class, 'operator_id', 'operator_id');
    }
}
