<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
    * The application's global HTTP middleware stack.
    *
    * These middleware are run during every request to your application.
    *
    * @var array
    */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Institution::class
    ];

    /**
    * The application's route middleware groups.
    *
    * @var array
    */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\Terms::class,
            \App\Http\Middleware\Email::class,
            \App\Http\Middleware\Confirm::class,
            \App\Http\Middleware\Requirements::class,
            \App\Http\Middleware\Commitment::class,
            \App\Http\Middleware\GeneralCommitment::class,
			\App\Http\Middleware\EncuestaGeneral::class
        ],
        'api' => [
            // 'throttle:60,1',
        ],
    ];

    /**
    * The application's route middleware.
    *
    * These middleware may be assigned to groups or used individually.
    *
    * @var array
    */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'subscription' => \App\Http\Middleware\Subscription::class,
        'intended' => \App\Http\Middleware\Intended::class,
        'ability' => \App\Http\Middleware\EntrustAbility::class,
        'react' => \App\Http\Middleware\React::class,
        'pasos_compra' => \App\Http\Middleware\PasosCompra::class,
        'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class,
    ];
}
