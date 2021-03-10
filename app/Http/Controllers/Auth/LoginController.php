<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    #guard
    protected $guard = 'web';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        //$this->middleware('guest')->except('logout');
        if ($request->guard)
            $this->guard = $request->guard;
    }

    public function redirectPath() {
        if ($this->guard == 'garden-help') {
            return 'garden-help/home';
        }
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->user_role == "driver") {
            \Session::flash('error', 'You are not allowed to login the portal');
            $this->logout($request);
        }
    }

    public function showLoginForm($client_name = null)
    {
        if(request()->getHost() == 'admin.doorder.eu' || str_contains(request()->url(),'doorder/login')) {
            return view("auth.doorder.login");
        } else if(str_contains(request()->url(),'garden-help/login')) {
            return view("auth.garden_help.login");
        } else {
            return view('auth.login');
        }
    }

    protected function guard()
    {
        return Auth::guard($this->guard);
    }

    public function logout(Request $request)
    {
        $url = '/';

        if (request()->getHost() == 'admin.doorder.eu') {
            $url = 'doorder/login';
        }

        //$this->guard()->logout();
        Auth::guard('web')->logout();
        Auth::guard('doorder')->logout();
        Auth::guard('garden-help')->logout();
        $request->session()->invalidate();

        return redirect($url);
    }
}
