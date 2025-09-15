<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * Accepts an array of IPs/CIDRs, "*" for any proxy, or null for none.
     *
     * @var array|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO;

    public function __construct()
    {
        $envValue = env('TRUSTED_PROXIES');

        if ($envValue === '*') {
            $this->proxies = '*';
            return;
        }

        if (is_string($envValue) && trim($envValue) !== '') {
            $this->proxies = array_map('trim', explode(',', $envValue));
            return;
        }

        $this->proxies = null;
    }
}


