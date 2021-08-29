<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset requests
     * | and uses a simple trait to include this behavior. You're free to
     * | explore this trait and override any methods you wish to tweak.
     * |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    public function showResetForm(Request $request, $token = null, $client_name = null)
    {
        if (strpos(request()->getHost(), 'doorder.eu') !== false || str_contains(request()->url(), 'doorder/password/reset')) {

            return view('auth.doorder.passwords.reset')->with([
                'token' => $token,
                'email' => $request->email
            ]);
        } else {
            return view('auth.doorder.passwords.reset')->with([
                'token' => $token,
                'email' => $request->email
            ]);
        }
    }
}
