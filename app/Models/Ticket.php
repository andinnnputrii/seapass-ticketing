<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'type',   // express | regular
        'price',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'price' => 'integer',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
