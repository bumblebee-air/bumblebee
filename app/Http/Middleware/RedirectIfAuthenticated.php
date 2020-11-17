<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::user();
            $user_role = $user->user_role;
            /*if($user_role == 'insurance'){
                return redirect()->intended('insurance/dashboard');
            }*/
//            if($user_role == 'admin'){
//                return redirect('dashboard');
//            } elseif($user_role == 'client'){
//                return redirect('client/dashboard');
//            }
//            return redirect('');
            return redirect('dashboard');
        } elseif (Auth::guard('doorder')->check()) {
            return redirect('doorder/dashboard');
        }

        return $next($request);
    }
}
