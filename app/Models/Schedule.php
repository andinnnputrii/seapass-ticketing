<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'ship_id',
        'origin_port',
        'dest_port',
        'departure_at',
        'arrival_estimated_at',
        'status',
        'note',
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_estimated_at' => 'datetime',
    ];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
