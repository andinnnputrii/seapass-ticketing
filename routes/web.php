<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KapalOperatorController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JadwalKapalController;
use App\Http\Controllers\TiketValidasiController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PenumpangController;

// Import Controller Admin (Agar kode lebih rapi dan tidak perlu tulis namespace panjang di bawah)
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- MODUL OPERASIONAL (BAHASA INDONESIA) ---
// Menggunakan tabel: kapals, operators, jadwals, tikets

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

// Tiket & Validasi
Route::prefix('tiket-validasi')->name('tiket-validasi.')->group(function () {
    Route::get('/', [TiketValidasiController::class, 'index'])->name('index');
    Route::post('/', [TiketValidasiController::class, 'store'])->name('store');
    Route::get('/{id}', [TiketValidasiController::class, 'show'])->name('show');
    Route::delete('/{id}', [TiketValidasiController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/validasi', [TiketValidasiController::class, 'validasi'])->name('validasi');
});
// Route::resource('tiket-validasi', TiketValidasiController::class); // Opsional jika sudah didefinisikan manual di atas
Route::post('tiket-validasi/{id}/validasi', [TiketValidasiController::class, 'validasi'])->name('tiket-validasi.validasi');

// Resource route untuk Data Penumpang
Route::resource('penumpang', PenumpangController::class)->parameters([
    'penumpang' => 'penumpang_id'
]);

// API Routes untuk AJAX
Route::get('/api/jadwal-kapal/{id}', [JadwalKapalController::class, 'show']);
Route::get('/api/tiket-validasi/{id}', [TiketValidasiController::class, 'show']);
// Di routes/web.php atau routes/admin.php

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter-month', [DashboardController::class, 'filterByMonth'])->name('dashboard.filter');
    Route::get('/dashboard/breakdown', [DashboardController::class, 'getBreakdownDetail'])->name('dashboard.breakdown');
});


// --- AUTHENTICATION ---
// Splash screen (landing page)
Route::get('/', [AdminAuthController::class, 'splash'])->name('splash');

// Login routes
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


// --- MODUL ADMIN / KEUANGAN (BAHASA INGGRIS) ---
// Menggunakan tabel: transactions, refunds, users (Sesuai skema Hybrid)

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Transaksi (TransactionController sudah kita edit agar relasinya ke 'tikets')
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/transactions/{id}', [TransactionController::class, 'show'])->name('admin.transactions.show');

    // Refund Management
    Route::get('/admin/refunds', [RefundController::class, 'index'])->name('admin.refunds.index');
    Route::post('/admin/refunds/{id}/approve', [RefundController::class, 'approve'])->name('admin.refunds.approve');
    Route::post('/admin/refunds/{id}/reject', [RefundController::class, 'reject'])->name('admin.refunds.reject');

    // Laporan & Analitik
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');

    // Pengguna & Akses
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{type}/{id}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/internal', [UserManagementController::class, 'storeInternal'])->name('admin.users.store.internal');
    Route::put('/admin/users/internal/{id}', [UserManagementController::class, 'updateInternal'])->name('admin.users.update.internal');
    Route::post('/admin/users/{type}/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('/admin/users/{type}/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/admin/users/{type}/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});

// --- DEBUGGING ROUTE (HAPUS NANTI JIKA SUDAH PRODUCTION) ---
// Akses URL: /test-relasi untuk mengecek apakah Laravel bisa membaca relasi database baru
Route::get('/test-relasi', function () {
    try {
        // 1. Ambil 1 transaksi acak
        $transaksi = \App\Models\Transaction::first();

        if (!$transaksi) {
            return response()->json([
                'status' => 'Data Kosong',
                'message' => 'Tabel transactions kosong. Silakan isi data dummy dulu di database.'
            ]);
        }

        // 2. Cek apakah bisa memanggil relasi 'tiket'
        // Jika null, berarti ticket_id di transaksi tidak cocok dengan id di tabel tikets
        $tiket = $transaksi->tiket;

        // 3. Cek apakah dari tiket bisa memanggil 'jadwal'
        $jadwal = $tiket ? $tiket->jadwal : null;

        return response()->json([
            'status_koneksi' => 'BERHASIL TERHUBUNG',
            'pesan' => 'Jika data di bawah ini muncul lengkap, relasi kamu sudah benar.',
            'data_transaksi' => $transaksi,
            'data_tiket_terkait' => $tiket ?? 'GAGAL: Relasi tiket tidak ditemukan (Cek ticket_id)',
            'data_jadwal_terkait' => $jadwal ?? 'GAGAL: Relasi jadwal tidak ditemukan (Cek jadwal_id di tiket)'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'ERROR KODINGAN / DATABASE',
            'error_message' => $e->getMessage(),
            'tips' => 'Cek apakah nama Model dan nama Tabel di database sudah sesuai.'
        ], 500);
    }
});
