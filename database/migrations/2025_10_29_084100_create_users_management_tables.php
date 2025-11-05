<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update users table (untuk pelanggan)
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('email');
                $table->enum('status', ['verified', 'unverified', 'suspended'])->default('unverified')->after('password');
                $table->timestamp('last_login')->nullable();
                $table->integer('total_trips')->default(0);
            });
        }

        // Activity logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_type'); // admin or user
            $table->unsignedBigInteger('user_id');
            $table->string('action'); // create, update, delete, login
            $table->string('module'); // transactions, users, etc
            $table->text('description')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        
        if (Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['phone', 'status', 'last_login', 'total_trips']);
            });
        }
    }
};