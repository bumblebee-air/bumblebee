<?php

namespace App\Http\Middleware;

use Closure;

class Insurance
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
        $current_user = $request->user();
        if($current_user->user_role != 'insurance'){
            return redirect()->back()->with('error', 'You aren\'t allowed to view this resource!');
        }
        return $next($request);
    }
}
