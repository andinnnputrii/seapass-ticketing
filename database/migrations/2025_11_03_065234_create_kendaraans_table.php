<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('kendaraan_id')->unique(); // KND001
            $table->string('tiket_id'); // TKT001
            $table->string('plat_nomor'); // L 9821 GG
            $table->string('jenis_kendaraan'); // Truk Kontainer, Bus, Pickup, dll
            $table->decimal('panjang', 5, 2); // 12.0 meter
            $table->integer('muatan'); // 12000 kg
            $table->timestamps();

            $table->foreign('tiket_id')->references('tiket_id')->on('tikets')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
