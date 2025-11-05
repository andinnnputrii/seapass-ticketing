<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Tambah kolom role setelah password
            $table->enum('role', ['admin', 'operator'])->default('operator')->after('password');
            
            // Tambah kolom status jika belum ada
            if (!Schema::hasColumn('admins', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            }
            
            // Tambah kolom last_login jika belum ada
            if (!Schema::hasColumn('admins', 'last_login')) {
                $table->timestamp('last_login')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'last_login']);
        });
    }
};