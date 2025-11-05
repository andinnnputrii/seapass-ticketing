<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id();
            $table->string('tiket_id')->unique();

            // Foreign Keys
            $table->string('penumpang_id');
            $table->foreign('penumpang_id')
                  ->references('penumpang_id')
                  ->on('penumpangs')
                  ->onDelete('cascade');

            $table->foreignId('jadwal_id')
                  ->constrained('jadwals')
                  ->onDelete('cascade');

            $table->string('kapal_id');
            $table->foreign('kapal_id')
                  ->references('kapal_id')
                  ->on('kapals')
                  ->onDelete('cascade');

            // Data Tiket
            $table->enum('tipe_tiket', ['Kendaraan', 'Penumpang'])->default('Penumpang');
            $table->enum('kelas_tiket', ['Ekonomi', 'Bisnis', 'VIP'])->default('Ekonomi');
            $table->string('kode_booking')->unique();

            // Harga
            $table->decimal('harga', 10, 2);
            $table->decimal('pajak', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2);

            // Pembayaran
            $table->enum('metode_bayar', ['QRIS', 'Tunai', 'Bank', 'E-Wallet'])->nullable();
            $table->enum('status_pembayaran', ['Pending', 'Paid', 'Refund'])->default('Pending');

            // Status Tiket
            $table->enum('status_tiket', ['Valid', 'Tervalidasi', 'Batal', 'Reschedule', 'Pending'])->default('Valid');

            // Detail Tambahan
            $table->string('nomor_kursi')->nullable();
            $table->string('nomor_kendaraan')->nullable();

            // Timestamp
            $table->dateTime('waktu_pemesanan')->nullable();
            $table->dateTime('waktu_pembayaran')->nullable();
            $table->dateTime('waktu_validasi')->nullable();
            $table->string('validasi_oleh')->nullable();

            // Catatan
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('tiket_id');
            $table->index('kode_booking');
            $table->index('status_tiket');
            $table->index('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
