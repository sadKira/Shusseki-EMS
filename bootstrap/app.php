<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\TsuushinMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\UserApprovalMiddleware;
use App\Http\Middleware\AccountStatusMiddleware;
use Illuminate\Http\Request;
 

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
            'super_admin' => SuperAdminMiddleware::class,
            'admin' => AdminMiddleware::class,
            'tsuushin' => TsuushinMiddleware::class,
            'user' => UserMiddleware::class,
            'role' => RoleMiddleware::class,
            'approved' => UserApprovalMiddleware::class,
            'pending' => UserApprovalMiddleware::class,
            'active' => AccountStatusMiddleware::class,
            'inactive' => AccountStatusMiddleware::class,
        ]);

        $middleware->trustProxies(
            '*',
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
