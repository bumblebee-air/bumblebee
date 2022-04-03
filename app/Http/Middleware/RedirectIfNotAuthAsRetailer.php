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
        $current_user = auth()->user();
        if ($current_user->user_role != 'retailer') {
            return redirect('/');
        }
        if(!$current_user->retailer_profile || $current_user->retailer_profile->status!='completed'){
            \Illuminate\Support\Facades\Auth::guard('doorder')->logout();
            \Illuminate\Support\Facades\Request::session()->invalidate();
            return redirect('doorder/login');
        }
        return $next($request);
    }
}
