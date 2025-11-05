<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id')->nullable();
            $table->string('id_jadwal', 20);
            $table->string('kapal_id', 20);
            $table->string('nama_kapal', 100);
            $table->text('perubahan');
            $table->string('diubah_oleh', 100);
            $table->text('alasan_perubahan')->nullable();
            $table->enum('jenis_perubahan', ['created', 'updated', 'status_changed', 'deleted'])->default('updated');
            $table->timestamps();

            // Foreign key (nullable karena bisa dihapus)
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_logs');
    }
};
