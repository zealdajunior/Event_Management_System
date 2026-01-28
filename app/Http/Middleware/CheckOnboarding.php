<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnboarding
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip check for admin users
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        // If user hasn't completed onboarding, redirect to onboarding
        if ($user && !$user->onboarding_completed && !$request->routeIs('onboarding.*')) {
            return redirect()->route('onboarding.step1');
        }

        return $next($request);
    }
}
