<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->string('id_jadwal', 20)->unique();
            $table->string('kapal_id', 20);
            $table->string('pelabuhan_asal', 100);
            $table->string('pelabuhan_tujuan', 100);
            $table->date('tanggal_keberangkatan');
            $table->time('jam_berangkat');
            $table->time('estimasi_kedatangan');
            $table->enum('status', ['On-Time', 'Delay', 'Cancelled'])->default('On-Time');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('kapal_id')->references('kapal_id')->on('kapals')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
