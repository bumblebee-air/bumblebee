<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UserClient;
use App\UserTwoFactor;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

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
    //guard
    protected $guard = 'web';
    //2FA check url
    protected $two_factor_url = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
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
                return $this->logout($request);
            }
            $the_score = $recaptcha_res->score;
            if($the_score <= 0.4){
                \Session::flash('error', 'Your request did not pass the assessment');
                return $this->logout($request);
            }
        }
        if ($user->user_role == "driver") {
            \Session::flash('error', 'You are not allowed to login the portal');
            return $this->logout($request);
        }
        //Check if unapproved retailer
        if($user && $user->user_role == 'retailer'){
            $retailer_profile = $user->retailer_profile;
            if($retailer_profile && $retailer_profile->status != 'completed'){
                \Session::flash('error', 'Your account has not been activated yet');
                return $this->logout($request);
            }
        }
        //dd($user);
        if($user->user_role == 'client' || $user->phone == null) {
            //Two factor authentication
            $sid = env('TWILIO_SID', '');
            $token = env('TWILIO_AUTH', '');
            $verify_sid = env('TWILIO_VERIFICATION_SID', '');
            try {
                $twilio = new Client($sid, $token);
                $verification = $twilio->verify->v2->services($verify_sid)
                    ->verifications
                    ->create($user->phone, 'sms');
                $last_attempt_sid = null;
                foreach ($verification->sendCodeAttempts as $attempt) {
                    if ($attempt['attempt_sid'] != null) {
                        $last_attempt_sid = $attempt['attempt_sid'];
                    }
                }
                if ($last_attempt_sid != null) {
                    $user_two_factor = new UserTwoFactor();
                    $user_two_factor->user_id = $user->id;
                    $user_two_factor->attempt_sid = $last_attempt_sid;
                    $user_two_factor->status = $verification->status;
                    $user_two_factor->save();
                    $this->two_factor_url = 'two-factor/verify/' . $last_attempt_sid;
                    return $this->logout($request);
                }
            } catch (\Exception $exception) {
                \Session::flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
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
        if($this->two_factor_url != null){
            $url = $this->two_factor_url;
        } else {
            if (strpos(request()->getHost(), 'doorder.eu') !== false) {
                $url = 'doorder/login';
            } else if (strpos(request()->getHost(), 'ghstaging') !== false) {
                $url = 'garden-help/login';
            }
        }
        //$this->guard()->logout();
        Auth::guard('web')->logout();
        Auth::guard('doorder')->logout();
        Auth::guard('garden-help')->logout();
        Auth::guard('doom-yoga')->logout();
        Auth::guard('unified')->logout();
        $error_msg = $request->session()->get('error');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if($error_msg!=null && $error_msg!=''){
            \Session::flash('error',$error_msg);
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($url);
    }

    public function getTwoFactorCheckForm($sid){
        $user_two_factor = UserTwoFactor::where('attempt_sid','=',$sid)->first();
        if(!$user_two_factor){
            \Session::flash('error','This verification attempt was not found!');
            return redirect()->back();
        }
        $the_user = $user_two_factor->user;
        $user_client = UserClient::where('user_id','=',$the_user->id)->first();
        $the_client = $user_client->client;
        $client_name = strtolower($the_client->name);
        $view_name = 'auth.two_factor_verify';
        if($client_name == 'doorder'){
            $this->guard = 'doorder';
            $view_name = 'auth.doorder.two_factor_verify';
        } elseif($client_name == 'gardenhelp'){
            $this->guard = 'garden-help';
        } elseif($client_name == 'doomyoga'){
            $this->guard = 'doom-yoga';
        } elseif($client_name == 'unified'){
            $this->guard = 'unified';
        }
        return view($view_name,['attempt_sid'=>$sid, 'phone'=>$the_user->phone,
            'guard'=>$this->guard]);
    }

    public function postTwoFactorCheck(Request $request){
        $guard = $request->get('guard');
        $code = $request->get('code');
        $attempt_sid = $request->get('attempt_sid');
        $user_two_factor = UserTwoFactor::where('attempt_sid','=',$attempt_sid)->first();
        if(!$user_two_factor){
            \Session::flash('error','This verification attempt was not found!');
            return redirect()->back();
        }
        $the_user = $user_two_factor->user;
        if($guard!=null){
            $this->guard = $guard;
        }
        //Check if the code is valid
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $verify_sid = env('TWILIO_VERIFICATION_SID','');
        try {
            $twilio = new Client($sid, $token);
            $verification = $twilio->verify->v2->services($verify_sid)
                ->verificationChecks
                ->create($code, ["to" => $the_user->phone]);
            $verification_status = $verification->status;
            $user_two_factor->status = $verification_status;
            $user_two_factor->save();
            if($verification_status == 'approved'){
                Auth::guard($this->guard)->loginUsingId($the_user->id,1);
                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
            }
        } catch (\Exception $exception){
            \Session::flash('error',$exception->getMessage());
            return redirect()->back();
        }
        $error_msg = 'The code is invalid, please try again';
        if($user_two_factor->status == 'canceled'){
            $error_msg = 'This code has expired, please retry logging in';
        }
        \Session::flash('error',$error_msg);
        return redirect()->back();
    }
}
