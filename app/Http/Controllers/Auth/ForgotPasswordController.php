<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset emails and
     * | includes a trait which assists in sending these notifications from
     * | your application to your users. Feel free to explore this trait.
     * |
     */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        if (strpos(request()->getHost(), 'doorder.eu') !== false || str_contains(request()->url(), 'doorder/password/reset')) {

            return view("auth.doorder.passwords.email");
        } else if (strpos(request()->getHost(), 'gardenhelp.ie') !== false || str_contains(request()->url(), 'garden-help/password/reset')) {
            return view("auth.garden_help.password.email");
        } else {
            return view('auth.passwords.email');
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        if (strpos(request()->getHost(), 'doorder.eu') !== false || str_contains(url()->previous(), 'doorder/password/reset')) {
            //Check if unapproved retailer
            $the_user = \App\User::where('email',$request->get('email'))->first();
            if($the_user && $the_user->user_role == 'retailer'){
                $retailer_profile = $the_user->retailer_profile;
                if($retailer_profile && $retailer_profile->status != 'completed'){
                    return redirect()->back()->withErrors(['message' => 'Your account has not been activated yet']);
                }
            }
            \Config::set('mail.from.address', 'no-reply@doorder.eu');
            \Config::set('mail.from.name', 'DoOrder');
            \Config::set('app.name', 'DoOrder');
        } else if (strpos(request()->getHost(), 'gardenhelp.ie') !== false || strpos(request()->getHost(), 'ghstaging') !== false || str_contains(request()->url(), 'garden-help/password/reset')) {
            \Config::set('mail.from.address', 'no-reply@gardenhelp.ie');
            \Config::set('mail.from.name', 'GardenHelp');
            \Config::set('app.name', 'GardenHelp');
        }
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        $response = '';
        if ($request->wantsJson()) {
            $response = new JsonResponse(['message' => trans($response)], 200);
        } else {
            alert()->success('Your reset password email has been sent.');
            $response = back()->with('status', trans($response));
        }
        return $response;
    }
}
