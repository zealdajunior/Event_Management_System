<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'check.onboarding' => \App\Http\Middleware\CheckOnboarding::class,
        ]);
        
        // Add optimization middleware
        $middleware->append(\App\Http\Middleware\OptimizeResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
