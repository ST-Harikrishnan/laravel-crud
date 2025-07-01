<?php

namespace App\Http;


use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ...

    protected $middleware = [
        // Global middleware
    ];

    protected $middlewareGroups = [
        // Middleware groups like 'web' and 'api'
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    
        // 'is_admin' => \App\Http\Middleware\IsAdmin::class,


        // ... other middleware
    ];
    
}
