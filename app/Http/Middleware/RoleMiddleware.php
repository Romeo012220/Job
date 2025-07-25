<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
public function handle($request, Closure $next, ...$roles)
{
    $user = auth()->user();

    if (!$user || !in_array($user->role, $roles)) {
        \Log::info("RoleMiddleware: User role: {$user->role}, required roles: " . implode(',', $roles));
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

}
