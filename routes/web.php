<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KapalOperatorController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JadwalKapalController;
use App\Http\Controllers\TiketValidasiController;


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

