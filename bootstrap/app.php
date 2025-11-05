<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
<<<<<<< HEAD
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
=======
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias untuk proteksi admin
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
        ]);
        
        // Opsional: Tambahkan middleware lain jika diperlukan
        // $middleware->alias([
        //     'role' => \App\Http\Middleware\CheckRole::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
>>>>>>> 5dbb5e9b770a1d1b6c8c08ef2fa4d8432bd2a547
