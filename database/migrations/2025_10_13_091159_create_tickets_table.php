<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->string('type'); // express | regular
            $table->unsignedInteger('price'); // dalam rupiah
            $table->dateTime('sold_at');
            $table->timestamps();
            $table->index(['sold_at', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
