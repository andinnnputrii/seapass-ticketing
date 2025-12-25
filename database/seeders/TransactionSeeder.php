<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Refund;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama - URUTAN PENTING: child dulu, baru parent
        Refund::truncate();
        Transaction::truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Dummy transactions - SEMUA user_id dan ticket_id = NULL
        $transactions = [
            [
                'order_number' => 'TRX001',
                'user_id' => null,
                'passenger_name' => 'Dimas Prasetyo',
                'passenger_phone' => '081234567890',
                'passenger_email' => 'dimas@example.com',
                'amount' => 150000,
                'payment_method' => 'QRIS',
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'order_number' => 'TRX002',
                'user_id' => null,
                'passenger_name' => 'Andi Wijaya',
                'passenger_phone' => '081234567891',
                'passenger_email' => 'andi@example.com',
                'amount' => 250000,
                'payment_method' => 'Transfer Bank',
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(4),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'order_number' => 'TRX003',
                'user_id' => null,
                'passenger_name' => 'Rina Maharani',
                'passenger_phone' => '081234567892',
                'passenger_email' => 'rina@example.com',
                'amount' => 200000,
                'payment_method' => 'Tunai',
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'order_number' => 'TRX004',
                'user_id' => null,
                'passenger_name' => 'Yuni Astuti',
                'passenger_phone' => '081234567893',
                'passenger_email' => 'yuni@example.com',
                'amount' => 200000,
                'payment_method' => 'QRIS',
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(2),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'order_number' => 'TRX005',
                'user_id' => null,
                'passenger_name' => 'Husein Alazka',
                'passenger_phone' => '081234567894',
                'passenger_email' => 'husein@example.com',
                'amount' => 130000,
                'payment_method' => 'Tunai',
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(1),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'order_number' => 'TRX006',
                'user_id' => null,
                'passenger_name' => 'Budi Santoso',
                'passenger_phone' => '081234567895',
                'passenger_email' => 'budi@example.com',
                'amount' => 180000,
                'payment_method' => 'E-Wallet',
                'payment_status' => 'pending',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($transactions as $data) {
            Transaction::create($data);
        }

        echo "✅ 6 transaksi berhasil dibuat!\n";

        // Dummy refunds
        $refunds = [
            [
                'transaction_id' => 1,
                'refund_number' => 'REF001',
                'reason' => 'Berhalangan hadir karena sakit',
                'refund_amount' => 150000,
                'status' => 'pending',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'transaction_id' => 2,
                'refund_number' => 'REF002',
                'reason' => 'Jadwal berubah mendadak',
                'refund_amount' => 250000,
                'status' => 'approved',
                'approved_by' => 1,
                'approved_at' => now()->subDay(),
                'admin_notes' => 'Refund disetujui sesuai kebijakan',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDay(),
            ],
            [
                'transaction_id' => 3,
                'refund_number' => 'REF003',
                'reason' => 'Kesalahan pemesanan tanggal',
                'refund_amount' => 200000,
                'status' => 'rejected',
                'approved_by' => 1,
                'approved_at' => now()->subHours(12),
                'admin_notes' => 'Refund ditolak karena melebihi batas waktu',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(12),
            ],
        ];

        foreach ($refunds as $data) {
            Refund::create($data);
        }

        echo "✅ 3 refund berhasil dibuat!\n";
    }
}
