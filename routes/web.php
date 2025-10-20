<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;

// Splash screen (landing page)
Route::get('/', [AdminAuthController::class, 'splash'])->name('splash');

// Login routes
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Admin Dashboard (protected)
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});