<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'ticket_id', // Ini Foreign Key ke tabel 'tikets'
        'passenger_name',
        'passenger_phone',
        'passenger_email',
        'amount',
        'payment_method',
        'payment_status',
        'paid_at',
        'payment_proof',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // Relasi ke User (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // PERBAIKAN: Relasi ke Tiket (Bahasa Indo)
    // Kita ubah nama fungsi jadi 'tiket' agar konsisten
    public function tiket()
    {
        // 'ticket_id' adalah kolom di tabel transactions
        // 'id' adalah primary key di tabel tikets
        return $this->belongsTo(Tiket::class, 'ticket_id', 'id');
    }

    // Relasi ke Refund
    public function refund()
    {
        return $this->hasOne(Refund::class);
    }

    // Helper: Cek apakah sudah lunas
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    // Helper: Badge status pembayaran
    public function getStatusBadge()
    {
        return match($this->payment_status) {
            'paid' => '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Lunas</span>',
            'pending' => '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>',
            'failed' => '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Gagal</span>',
            'refunded' => '<span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Refund</span>',
            default => '-',
        };
    }
}
