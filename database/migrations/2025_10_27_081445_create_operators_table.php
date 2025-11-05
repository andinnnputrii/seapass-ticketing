<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->string('operator_id')->primary();
            $table->string('nama_operator');
            $table->string('alamat')->nullable();
            $table->string('no_telepon')->nullable();            $table->string('email')->nullable();
            $table->integer('jumlah_kapal')->default(0);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
