<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kapals', function (Blueprint $table) {
            $table->string('kapal_id', 20)->primary();
            $table->string('nama_kapal', 100);
            $table->string('jenis_kapal', 50);
            $table->string('operator_id', 20);
            $table->integer('kapasitas')->nullable(); // Total kapasitas penumpang
            $table->string('pelabuhan_asal', 100)->nullable();
            $table->string('rute_aktif', 200)->nullable();
            $table->date('tanggal_registrasi')->nullable();
            $table->enum('status_operasional', ['Beroperasi', 'Maintenance', 'Tidak Beroperasi'])->default('Beroperasi');
            $table->enum('status_kebersihan', ['Sangat Bersih', 'Bersih', 'Cukup Bersih', 'Kurang Bersih'])->nullable();
            $table->string('foto_kapal')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->string('nomor_registrasi', 50)->nullable();
            $table->year('tahun_pembuatan')->nullable();
            $table->decimal('panjang_kapal', 8, 2)->nullable();
            $table->decimal('lebar_kapal', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('operator_id')->references('operator_id')->on('operators')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kapals');
    }
};
