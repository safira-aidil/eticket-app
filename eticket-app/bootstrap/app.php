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
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Mendaftarkan Alias Middleware Admin
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // 2. Atur Redirect Global (Versi Stabil Laravel 11)
        // Ini memastikan tamu dilempar ke login, dan yang sudah login ke dashboard
        $middleware->redirectTo(
            guests: '/login',
            users: '/dashboard'
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();