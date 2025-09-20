<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user || $user->role != UserRole::Super_Admin) {
            return back();
        }

        // Get the user agent string
        $userAgent = $request->server('HTTP_USER_AGENT');

        // Check if the user agent contains "Mobile" or "Android" or "iPhone" etc.
        if (str_contains($userAgent, 'Mobile') || str_contains($userAgent, 'Android') || str_contains($userAgent, 'iPhone')) {
            // If it's a mobile device, redirect to a restricted page or show an error
            return Redirect::to('/'); // Or any other restricted URL
        }
        
        return $next($request);
    }
}
