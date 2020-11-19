<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAuthAsRetailer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->user_role != 'retailer') {
            return redirect('/');
        }
        return $next($request);
    }
}
