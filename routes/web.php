<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KapalOperatorController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JadwalKapalController;
use App\Http\Controllers\TiketValidasiController;
use App\Http\Controllers\Auth\AdminAuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Kapal & Operator
Route::get('/kapal-operator', [KapalOperatorController::class, 'index'])->name('kapal-operator.index');
Route::get('/kapal-operator/create', [KapalOperatorController::class, 'create'])->name('kapal-operator.create');
Route::post('/kapal-operator', [KapalOperatorController::class, 'store'])->name('kapal-operator.store');
Route::get('/kapal-operator/{id}/edit', [KapalOperatorController::class, 'edit'])->name('kapal-operator.edit');
Route::put('/kapal-operator/{id}', [KapalOperatorController::class, 'update'])->name('kapal-operator.update');
Route::delete('/kapal-operator/{id}', [KapalOperatorController::class, 'destroy'])->name('kapal-operator.destroy');
Route::post('/kapal-operator/sync', [KapalOperatorController::class, 'sync'])->name('kapal-operator.sync');
Route::resource('operator', OperatorController::class);

// Jadwal Kapal Routes - ROUTE SPESIFIK HARUS DI ATAS ROUTE DINAMIS
Route::prefix('jadwal-kapal')->name('jadwal-kapal.')->group(function () {
    // Route spesifik (tanpa parameter) harus di atas
    Route::get('/', [JadwalKapalController::class, 'index'])->name('index');
    Route::post('/', [JadwalKapalController::class, 'store'])->name('store');
    Route::post('/sync', [JadwalKapalController::class, 'sync'])->name('sync');
    Route::get('/logs/export', [JadwalKapalController::class, 'exportLogs'])->name('logs.export');

    // Route dengan parameter harus di bawah
    Route::get('/{id}', [JadwalKapalController::class, 'show'])->name('show');
    Route::put('/{id}', [JadwalKapalController::class, 'update'])->name('update');
    Route::delete('/{id}', [JadwalKapalController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/logs', [JadwalKapalController::class, 'showLogs'])->name('logs');
});

Route::prefix('tiket-validasi')->name('tiket-validasi.')->group(function () {
    Route::get('/', [TiketValidasiController::class, 'index'])->name('index');
    Route::post('/', [TiketValidasiController::class, 'store'])->name('store');
    Route::get('/{id}', [TiketValidasiController::class, 'show'])->name('show');
    Route::delete('/{id}', [TiketValidasiController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/validasi', [TiketValidasiController::class, 'validasi'])->name('validasi');
});

Route::resource('tiket-validasi', TiketValidasiController::class);
Route::post('tiket-validasi/{id}/validasi', [TiketValidasiController::class, 'validasi'])->name('tiket-validasi.validasi');

// API Routes untuk AJAX
Route::get('/api/jadwal-kapal/{id}', [JadwalKapalController::class, 'show']);
Route::get('/api/tiket-validasi/{id}', [TiketValidasiController::class, 'show']);

// Splash screen (landing page)
Route::get('/', [AdminAuthController::class, 'splash'])->name('splash');

// Login routes
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin Dashboard (protected)
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

});

// Admin Dashboard (protected)
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Transaksi & Refund
    Route::get('/admin/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/transactions/{id}', [\App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('admin.transactions.show');

    // Refund Management
    Route::get('/admin/refunds', [\App\Http\Controllers\Admin\RefundController::class, 'index'])->name('admin.refunds.index');
    Route::post('/admin/refunds/{id}/approve', [\App\Http\Controllers\Admin\RefundController::class, 'approve'])->name('admin.refunds.approve');
    Route::post('/admin/refunds/{id}/reject', [\App\Http\Controllers\Admin\RefundController::class, 'reject'])->name('admin.refunds.reject');

    // Laporan & Analitik
    Route::get('/admin/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

    // Pengguna & Akses
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{type}/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/internal', [\App\Http\Controllers\Admin\UserManagementController::class, 'storeInternal'])->name('admin.users.store.internal');
    Route::put('/admin/users/internal/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateInternal'])->name('admin.users.update.internal');
    Route::post('/admin/users/{type}/{id}/reset-password', [\App\Http\Controllers\Admin\UserManagementController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('/admin/users/{type}/{id}/toggle-status', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/admin/users/{type}/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('admin.users.destroy');

});

