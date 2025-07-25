<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware; // ✅ Your custom middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',             // ✅ Web routes
        commands: __DIR__.'/../routes/console.php',     // ✅ Artisan commands
        health: '/up',                                  // ✅ Health check (optional)
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class, // ✅ Now you can use `->middleware('role:admin')` in routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Optional: customize exception handling here
    })
    ->create();
