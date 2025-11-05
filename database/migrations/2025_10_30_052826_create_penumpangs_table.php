<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penumpangs', function (Blueprint $table) {
            $table->string('penumpang_id')->primary();
            $table->string('nama_lengkap');
            $table->string('nik')->unique()->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nama_lengkap');
            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penumpangs');
    }
};
