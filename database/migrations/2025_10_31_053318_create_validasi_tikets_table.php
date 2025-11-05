<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('validasi_tikets', function (Blueprint $table) {
            $table->id();
            $table->string('tiket_id');
            $table->timestamp('waktu_validasi');
            $table->enum('status_validasi', ['valid', 'invalid', 'gagal'])->default('valid');
            $table->string('metode'); // QR, Manual
            $table->string('lokasi_pintu'); // Gate A1, Gate B2
            $table->string('petugas'); // petugas01
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('tiket_id')->references('tiket_id')->on('tikets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validasi_tikets');
    }
};
