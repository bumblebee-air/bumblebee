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
        } elseif ($this->guard == 'doom-yoga') {
            return 'doom-yoga/customers/registrations';
        } elseif ($this->guard == 'unified') {
            return 'unified/customers/list';
        }
        return '/';
    }

    protected function authenticated(Request $request, $user) {
        //Check for and apply recaptcha assessment
        $recaptcha_token = $request->get('recaptcha_token');
        if($recaptcha_token!=null){
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $fields = [
                'secret' => env('RECAPTCHA_SECRET'),
                'response' => $recaptcha_token
            ];
            $ch = curl_init ();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $result = curl_exec($ch);
            curl_close($ch);
            $recaptcha_res = json_decode($result);
            if($recaptcha_res->success!=true || $recaptcha_res->action!='login'){
                \Session::flash('error', 'Your request did not pass the assessment');
                $this->logout($request);
            }
            $the_score = $recaptcha_res->score;
            if($the_score <= 0.4){
                \Session::flash('error', 'Your request did not pass the assessment');
                $this->logout($request);
            }
        }
        if ($user->user_role == "driver") {
            \Session::flash('error', 'You are not allowed to login the portal');
            $this->logout($request);
        }
        //Check if unapproved retailer
        if($user && $user->user_role == 'retailer'){
            $retailer_profile = $user->retailer_profile;
            if($retailer_profile && $retailer_profile->status != 'completed'){
                \Session::flash('error', 'Your account has not been activated yet');
                $this->logout($request);
            }
        }
        //dd($user);
    }

    public function showLoginForm($client_name = null)
    {
        if(strpos(request()->getHost(),'doorder.eu')!==false || str_contains(request()->url(),'doorder/login')) {
            return view("auth.doorder.login");
        } else if(str_contains(request()->url(),'garden-help/login')) {
            return view("auth.garden_help.login");
        }else if(str_contains(request()->url(),'doom-yoga/login')) {
            return view("auth.doom_yoga.login");
        }else if(strpos(request()->getHost(),'unified.')!==false || str_contains(request()->url(),'unified/login')) {
            return view("auth.unified.login");
        }else if(strpos(request()->getHost(),'ghstaging.')!==false || strpos(request()->getHost(),'gardenhelp.ie')!==false || str_contains(request()->url(),'garden-help/login')) {
            return view('auth.garden_help.login');
        } else {
            return view('auth.login');
        }
    }

    protected function guard() {
        return Auth::guard($this->guard);
    }

    public function logout(Request $request) {
        $url = '/';

        if (strpos(request()->getHost(),'doorder.eu')!==false) {
            $url = 'doorder/login';
        } else if (strpos(request()->getHost(),'ghstaging')!==false) {
            $url = 'garden-help/login';
        }
        //$this->guard()->logout();
        Auth::guard('web')->logout();
        Auth::guard('doorder')->logout();
        Auth::guard('garden-help')->logout();
        Auth::guard('doom-yoga')->logout();
        Auth::guard('unified')->logout();
        $error_msg = $request->session()->get('error');
        $request->session()->invalidate();
        if($error_msg!=null && $error_msg!=''){
            \Session::flash('error',$error_msg);
        }
        return redirect($url);
    }
}
