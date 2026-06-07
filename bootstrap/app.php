<?php

use App\Http\Middleware\Administrator;
use App\Http\Middleware\Guru;
use App\Http\Middleware\Kabalai;
use App\Http\Middleware\Operator;
use App\Http\Middleware\Verifikator;
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
         $middleware -> alias([
             'Administrator' => Administrator::class,
             'Operator' => Operator::class,
             'Verifikator' => Verifikator::class,
             'Kabalai' => Kabalai::class,
             'Guru' => Guru::class,
         ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
