<?php

namespace App\Http\Middleware;

use Closure;

class AllowCORS
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //Set the CORS header
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}