<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
            add() → middleware global que se ejecuta en todas las requests.
            alias() → middleware que se puede aplicar solo a rutas específicas.
        */

        $middleware->alias([
            'auth' => App\Http\Middleware\Authenticate::class,
            'inactive' => App\Http\Middleware\SessionTimeout::class,
            'sanitize' => App\Http\Middleware\SanitizeId::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
