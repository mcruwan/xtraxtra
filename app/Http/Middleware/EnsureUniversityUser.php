<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUniversityUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isUniversityUser()) {
            abort(403, 'Unauthorized action.');
        }

        if (!auth()->user()->isActive()) {
            abort(403, 'Your account is not active. Please contact administrator.');
        }

        return $next($request);
    }
}
