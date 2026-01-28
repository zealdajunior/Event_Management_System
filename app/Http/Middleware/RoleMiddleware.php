<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $roles = null): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // if no roles required, allow access
        if (! $roles) {
            return $next($request);
        }

        $allowed = explode('|', $roles);
        $userRole = $user->role ?? 'user'; // default to 'user' if NULL

        $hasRole = method_exists($user, 'hasRole')
            ? $user->hasRole($roles)
            : in_array($userRole, $allowed, true);

        if (! $hasRole) {
            abort(403, 'Unauthorized. You do not have the required role.');
        }

        return $next($request);
    }
}