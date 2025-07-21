<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user.auth' => \App\Http\Middleware\UserAuthMiddleware::class,
            'lawyer.auth' => \App\Http\Middleware\LawyerAuthMiddleware::class,
            'guest.redirect' => \App\Http\Middleware\GuestRedirectMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withBroadcasting(__DIR__ . '/../routes/channels.php')
    ->create();
