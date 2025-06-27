<?php

namespace App\Http\Middleware;

use App\Enums\AccountStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to the access_denied route
        if ($request->routeIs('access_denied')) {
            return $next($request);
        }

        // Checks if user is active
        if (Auth::check() && Auth::user()->account_status !== AccountStatus::Active) {
            return redirect()->route('access_denied');
        }
        return $next($request);
    }
}
