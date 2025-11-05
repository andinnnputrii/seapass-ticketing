<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DashboardController;


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




