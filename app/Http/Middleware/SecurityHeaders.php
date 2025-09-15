<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff', false);
        $response->headers->set('X-Frame-Options', 'DENY', false);
        $response->headers->set('Referrer-Policy', 'no-referrer', false);
        $response->headers->set('Permissions-Policy', "geolocation=(), microphone=(), camera=(), interest-cohort=()", false);

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload', false);
        }

        // Strict CSP assuming only same-origin assets. Adjust if you add CDNs.
        $csp = [
            "default-src 'self'",
            "img-src 'self' data:",
            "style-src 'self'",
            "script-src 'self'",
            "font-src 'self' data:",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $csp), false);

        return $response;
    }
}


