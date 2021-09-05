<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotAuthAsClientOrDriverManager
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
        $user_role = auth()->user()->user_role;
        if ($user_role != 'client' && $user_role!= 'admin' && $user_role != 'driver_manager') {
            return redirect('/');
        }
        return $next($request);
    }
}
