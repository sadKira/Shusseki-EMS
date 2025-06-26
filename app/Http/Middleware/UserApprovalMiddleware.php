<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserApproval;

class UserApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to the approval_pending route
        if ($request->routeIs('approval_pending')) {
            return $next($request);
        }

        // Checks if user is approved
        if (Auth::check() && Auth::user()->status !== UserApproval::Approved) {
            return redirect()->route('approval_pending');
        }
        return $next($request);
    }
}
