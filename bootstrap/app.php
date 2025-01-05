<?php

use App\Http\Middleware\MustResetAccount;
use App\Http\Middleware\SuspendedUser;
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
        $middleware->alias([
            'reset'=>MustResetAccount::class,
            'suspended' => SuspendedUser::class
        ]);
       // $middleware->alias(['suspended' => SuspendedUser::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
