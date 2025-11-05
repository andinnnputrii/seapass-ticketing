<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('ship_id')->constrained('ships')->cascadeOnDelete();
            $table->string('origin_port');
            $table->string('dest_port');
            $table->dateTime('departure_at');
            $table->dateTime('arrival_estimated_at')->nullable();
            $table->string('status')->default('On-Time'); // On-Time | Delay
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
