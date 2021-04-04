<?php

namespace App\Http\Controllers;

use App\Managers\StripeManager;
use App\StripeAccount;
use App\User;
use Illuminate\Http\Request;
use Response;
use Twilio\Rest\Client;

class StripeController extends Controller
{
    private $stripe_key = '';
    public function __construct(){
        $stripe_key = env('STRIPE_SECRET');
        $this->stripe_key = $stripe_key;
    }

    public function getAccountCreationTest(){
        return view('stripe_account_creation_test');
    }

    public function postAccountCreationTest(Request $request){
        //dd($request->all());
        $name = $request->get('name');
        $first_name = '';
        $last_name = '';
        if($name!=null){
            $name_split = explode(' ',$name,2);
            $first_name = $name_split[0];
            if(isset($name_split[1])){
                $last_name = $name_split[1];
            }
        }
        $phone = $request->get('phone');
        $email = $request->get('email');
        $address = $request->get('address');
        $stripe_key = $this->stripe_key;
        if($stripe_key==null){
            dd('Stripe secret key is not configured');
        }
        try {
            $user = new User();
            $user->phone = $phone;
            $user->email = $email;
            $user->name = $name;
            $user->user_role = 'customer';
            $user->password = bcrypt('P@$$w0rd');
            $user->save();
        } catch(\Exception $exception) {
            \Session::flash('error',$exception->getMessage());
            return redirect()->back();
        }
        $stripe = new \Stripe\StripeClient($stripe_key);
        $stripe_account = $stripe->accounts->create([
            'type' => 'custom',
            'country' => 'IE',
            'email' => $email,
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'individual' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'email' => $email,
                'address' => [
                    'line1' => $address
                ]
            ]
        ]);
        //dd($stripe_account);
        $onboard_code = '';
        for ($i = 0; $i<8; $i++) {
            $onboard_code .= mt_rand(0,9);
        }
        $new_stripe_account = new StripeAccount();
        $new_stripe_account->user_id = $user->id;
        $new_stripe_account->account_id = $stripe_account->id;
        $new_stripe_account->business_type = $stripe_account->business_type;
        $new_stripe_account->type = 'custom';
        $new_stripe_account->onboard_code = $onboard_code;
        $new_stripe_account->save();
        //send onboarding link to user
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $message_body = 'Hi '.$first_name.', press the following link to start your Stripe account on-boarding: '.
            url('stripe-onboard/'.$onboard_code);
        $message = $twilio->messages->create($phone,
            ["from" => "+447445341335",
                "body" => $message_body]
        );
        \Session::flash('success','Account creation successful! you\'ll receive an on-boarding link on your phone');
        return redirect()->back();
    }

    public function getOnboard($onboard_code){
        $stripe_account = StripeAccount::where('onboard_code','=',$onboard_code)->first();
        //dd($stripe_account);
        if(!$stripe_account){
            return view('stripe_onboard',['title'=>'Error', 'text'=>'No registered account was found!']);
        }
        $stripe_key = $this->stripe_key;
        if($stripe_key==null){
            dd('Stripe secret key is not configured');
        }
        $stripe = new \Stripe\StripeClient($stripe_key);
        $account_link = $stripe->accountLinks->create([
            'account' => $stripe_account->account_id,
            'refresh_url' => url('stripe-onboard/stripe/refresh'),
            'return_url' => url('stripe-onboard/stripe/success'),
            'type' => 'account_onboarding',
        ]);
        return redirect()->to($account_link->url);
    }

    public function getOnboardRefresh(){
        return view('stripe_onboard',['title'=>'Refresh required', 'text'=>'Please click again on the link sent to your phone to refresh the Stripe on-boarding form']);
    }

    public function getOnboardSuccess(){
        $logo = '';
        $favicon = '';
        $request_url = request()->url();
        if(strpos($request_url,'doorder.com')!==false){
            $logo = asset('images/doorder-logo.png');
            $favicon = asset('images/doorder-favicon.svg');
        }
        return view('stripe_onboard',['title'=>'Success',
            'text'=>'The Stripe on-boarding form has been submitted successfully, please make sure that there were no missing data',
            'logo'=>$logo, 'favicon'=>$favicon]);
    }

    public function accountUpdateWebhook(Request $request){
        //\Log::info(json_encode($request->all()));
        $account_ready_flag = true;
        $account_id = $request->get('account');
        $data = $request->get('data');
        if($account_id==null){
            $account_id = $data['object']['id'];
        }
        $stripe_account = StripeAccount::where('account_id','=',$account_id)->first();
        if(!$stripe_account){
            return response()->json('No account was found with this ID!');
        }
        $account_requirements = $data['object']['requirements'];
        $currently_due_reqs = $account_requirements['currently_due'];
        if(count($currently_due_reqs)>0){
            \Log::info(json_encode($currently_due_reqs));
            $account_ready_flag = false;
        }
        $eventually_due_reqs = $account_requirements['eventually_due'];
        if(count($eventually_due_reqs)>0){
            \Log::info(json_encode($eventually_due_reqs));
            $account_ready_flag = false;
        }
        $stripe_account->onboard_status = ($account_ready_flag==true)? 'complete' : 'incomplete';
        $stripe_account->save();
        if($account_ready_flag==true){
            $str_man = new StripeManager();
            $str_man->stripeAccountOnboardComplete($account_id);
        }
        return response()->json('Webhook received successfully');
    }
}