<?php

namespace App\Http\Controllers;

use App\Helpers\TwilioHelper;
use App\Managers\StripeManager;
use App\Retailer;
use App\StripeAccount;
use App\StripePaymentLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Response;
use Stripe\Stripe;
use Twilio\Rest\Client;

class StripeController extends Controller
{
    private $stripe_key = '';
    private $requirements_titles = [
        'business_profile.mcc' => 'Merchant category code',
        'business_profile.url' => "Business URL",
        'business_profile.product_description' => "Business URL",
        'tos_acceptance.ip' => "Terms of service",
        'tos_acceptance.date' => "Terms of service",
        'external_account' => 'External account',
        'individual.first_name' => "Name",
        'individual.last_name' => "Name",
        "individual.dob.day" => "Birthdate",
        "individual.dob.month" => "Birthdate",
        "individual.dob.year" => "Birthdate",
        "individual.address.line1" => "Address",
        "individual.address.city" => "Address",
        "individual.address.state" => "Address",
        "individual.email" => "Email",
        "individual.phone" => "Phone",
        "company.name" => "Company Name",
        "company.address.line1" => "Company Address",
        "company.address.city" => "Company Address",
        "company.address.state" => "Company Address",
        "company.phone" => "Company Phone",
        "company.tax_id" => "Company Tax ID",
        "company.executives_provided" => "Executives provided",
        "company.owners_provided" => "Owners provided",
        "representative.first_name" => "Representative Name",
        "representative.last_name" => "Representative Name",
        "representative.dob.day" => "Representative Birthdate",
        "representative.dob.month" => "Representative Birthdate",
        "representative.dob.year" => "Representative Birthdate",
        "representative.address.city" => "Representative Address",
        "representative.address.line1" => "Representative Address",
        "representative.address.state" => "Representative Address",
        "representative.email" => "Representative Email",
        "representative.phone" => "Representative Phone",
        "representative.relationship.executive" => "Relationship with company",
        "representative.relationship.title" => "Relationship with company",
        "directors.first_name" => "Directors Name",
        "directors.last_name" => "Directors Name",
        "directors.dob.day" => "Directors Birthdate",
        "directors.dob.month" => "Directors Birthdate",
        "directors.dob.year" => "Directors Birthdate",
        "directors.email" => "Directors Email",
        "directors.relationship.title" => "Relationship with company",
        "owners.first_name" => "Owner Name",
        "owners.last_name" => "Owner Name",
        "owners.dob.day" => "Owner Birthdate",
        "owners.dob.month" => "Owner Birthdate",
        "owners.dob.year" => "Owner Birthdate",
        "owners.address.city" => "Owner Address",
        "owners.address.line1" => "Owner Address",
        "owners.address.state" => "Owner Address",
        "owners.email" => "Owner Email",
        "executives.first_name" => "Executives Name",
        "executives.last_name" => "Executives Name",
        "executives.dob.day" => "Executives Birthdate",
        "executives.dob.month" => "Executives Birthdate",
        "executives.dob.year" => "Executives Birthdate",
        "executives.address.city" => "Executives Address",
        "executives.address.line1" => "Executives Address",
        "executives.address.state" => "Executives Address",
        "executives.email" => "Executives Email",
    ];

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
        $branding = $this->fetchPageBranding();
        $logo = $branding['logo'];
        $favicon = $branding['favicon'];
        $stripe_account = StripeAccount::where('onboard_code','=',$onboard_code)->first();
        //dd($stripe_account);
        if(!$stripe_account){
            return view('stripe_onboard',['title'=>'Error',
                'text'=>'No registered account was found!',
                'logo'=>$logo, 'favicon'=>$favicon]);
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
        $branding = $this->fetchPageBranding();
        $logo = $branding['logo'];
        $favicon = $branding['favicon'];
        return view('stripe_onboard',['title'=>'Refresh required',
            'text'=>'Please click again on the link sent to your phone to refresh the Stripe on-boarding form',
            'logo'=>$logo, 'favicon'=>$favicon]);
    }

    public function getOnboardSuccess(){
        $branding = $this->fetchPageBranding();
        $logo = $branding['logo'];
        $favicon = $branding['favicon'];
        return view('stripe_onboard',['title'=>'Success',
            'text'=>'The Stripe on-boarding form has been submitted successfully, please make sure that there were no missing data',
            'logo'=>$logo, 'favicon'=>$favicon]);
    }

    public function fetchPageBranding(){
        $logo = '';
        $favicon = '';
        $request_url = request()->url();
        if(strpos($request_url,'doorder.')!==false){
            $logo = asset('images/doorder-logo.png');
            $favicon = asset('images/doorder-favicon.svg');
        }elseif(strpos($request_url,'gardenhelp')!==false
            || strpos($request_url,'ghstaging.')!==false
            || strpos($request_url,'iot.bumblebeeai')!==false){
            $logo = asset('images/Garden-Help-Logo.png');
            $favicon = asset('images/garden-help-fav.png');
        }
        return ['logo'=>$logo, 'favicon'=>$favicon];
    }

    public function accountUpdateWebhook(Request $request){
        \Log::info('New Stripe request on update');
        \Log::info(json_encode($request->all()));
        $account_ready_flag = true;
        $account_id = $request->get('account');
        $data = $request->get('data');
        $requirements_array = [];
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
            foreach ($currently_due_reqs as $item) {
                $is_exists = self::checkIfRequirementExists($item, $requirements_array);
                if (!$is_exists) {
                    $requirements_array[] = $item;
                }
            }
            \Log::info(json_encode($currently_due_reqs));
            $account_ready_flag = false;
        }
        $eventually_due_reqs = $account_requirements['eventually_due'];
        if(count($eventually_due_reqs)>0){
            foreach ($eventually_due_reqs as $item) {
                $is_exists = self::checkIfRequirementExists($item, $requirements_array);
                if (!$is_exists) {
                    $requirements_array[] = $item;
                }
            }
            \Log::info(json_encode($eventually_due_reqs));
            $account_ready_flag = false;
        }
        $past_due_reqs = $account_requirements['past_due'];
        if(count($past_due_reqs)>0){
            foreach ($past_due_reqs as $item) {
                $is_exists = self::checkIfRequirementExists($item, $requirements_array);
                if (!$is_exists) {
                    $requirements_array[] = $item;
                }
            }
            \Log::info(json_encode($eventually_due_reqs));
            $account_ready_flag = false;
        }
        if (count($requirements_array) > 0) {
            $user = $stripe_account->user;
            $message = "Hi $user->name, your Stripe account has been submitted but it's missing the following data: \r\n";
            foreach ($requirements_array as $item) {
                if (array_key_exists($item, $this->requirements_titles)) {
                    $message .= $this->requirements_titles[$item] . "\r\n";
                } else {
                    Log::warning("There requirement not exists: $item");
                }
            }
            $client = $user->client->client;
            TwilioHelper::sendSMS($client->name, $user->phone, $message);
        }
        $stripe_account->onboard_status = ($account_ready_flag==true)? 'complete' : 'incomplete';
        $stripe_account->save();
        if($account_ready_flag==true){
            $str_man = new StripeManager();
            $str_man->stripeAccountOnboardComplete($account_id);
        }
        return response()->json('Webhook received successfully');
    }

    private static function checkIfRequirementExists($item, $requirements_array) {
        $is_exists = false;
        if (!in_array($item, $requirements_array)) {
            if (in_array($item, ['tos_acceptance.ip', 'tos_acceptance.date'])) {
                $similar_items = ['tos_acceptance.ip', 'tos_acceptance.date'];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["individual.first_name" ,"individual.last_name"])) {
                $similar_items = ["individual.first_name" ,"individual.last_name"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["business_profile.product_description" ,"business_profile.url"])) {
                $similar_items = ["business_profile.product_description" ,"business_profile.url"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["individual.dob.day" ,"individual.dob.month", "individual.dob.year"])) {
                $similar_items = ["individual.dob.day" ,"individual.dob.month", "individual.dob.year"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["individual.address.line1", "individual.address.city", "individual.address.state"])) {
                $similar_items = ["individual.address.line1", "individual.address.city", "individual.address.state"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["company.address.line1", "company.address.city", "company.address.state"])) {
                $similar_items = ["company.address.line1", "company.address.city", "company.address.state"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["representative.first_name", "representative.last_name"])) {
                $similar_items = ["representative.first_name", "representative.last_name"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["representative.dob.day", "representative.dob.month","representative.dob.year"])) {
                $similar_items = ["representative.dob.day", "representative.dob.month","representative.dob.year"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["representative.address.line1","representative.address.city", "representative.address.state"])) {
                $similar_items = ["representative.address.line1","representative.address.city", "representative.address.state"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["representative.relationship.executive", "representative.relationship.title"])) {
                $similar_items = ["representative.relationship.executive", "representative.relationship.title"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["directors.first_name", "directors.last_name"])) {
                $similar_items = ["directors.first_name", "directors.last_name"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["directors.dob.day", "directors.dob.month", "directors.dob.year"])) {
                $similar_items = ["directors.dob.day", "directors.dob.month", "directors.dob.year"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["owners.first_name", "owners.last_name"])) {
                $similar_items = ["owners.first_name", "owners.last_name"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["owners.dob.day", "owners.dob.month", "owners.dob.year"])) {
                $similar_items = ["owners.dob.day", "owners.dob.month", "owners.dob.year"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["owners.address.line1", "owners.address.city", "owners.address.state"])) {
                $similar_items = ["owners.address.line1", "owners.address.city", "owners.address.state"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["executives.first_name", "executives.last_name"])) {
                $similar_items = ["executives.first_name", "executives.last_name"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["executives.dob.day", "executives.dob.month", "executives.dob.year"])) {
                $similar_items = ["executives.dob.day", "executives.dob.month", "executives.dob.year"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            } else if (in_array($item, ["executives.address.line1","executives.address.city", "executives.address.state"])) {
                $similar_items = ["executives.address.line1","executives.address.city", "executives.address.state"];
                foreach ($similar_items as $recurred_item) {
                    if (in_array($recurred_item, $requirements_array)) {
                        $is_exists = true;
                    }
                }
            }
        }
        return $is_exists;
    }

    public function setInvoicePaymentIntent(Request $request){
        try {
            $stripe_secret = env('STRIPE_SECRET');
            Stripe::setApiKey($stripe_secret);
            $amount = $request->get('amount');
            $amount = floatval($amount);
            $invoice_number = $request->get('invoice_number');
            $customer_name = $request->get('customer_name');
            $payment_intent = \Stripe\PaymentIntent::create([
                'payment_method_types' => ['card'],
                'amount' => $amount * 100,
                'currency' => 'eur',
                'description' => 'Invoice No.: ' . $invoice_number
                /*'application_fee_amount' => $amount*10,
                'transfer_data' => [
                    'destination' => 'acct_1H6cxdDEnaX8ijhf',
                ],*/
            ]);
        } catch (\Exception $e){
            return json_encode(['client_secret' => null,
                'error'=>1, 'error_message'=>$e->getMessage()]);
        }
        return json_encode(['client_secret' => $payment_intent->client_secret,
            'error'=>0, 'error_message'=>'']);
    }

    public function setCustomerSetupIntent(Request $request){
        $intent_type = $request->get('intent_type');
        $retailer_id = $request->get('retailer_id');
        $retailer = Retailer::find($retailer_id);
        if(!$retailer){
            return json_encode([
                'error' => 1,
                'message' => 'No Retailer account was found!',
                'client_secret' => null
            ]);
        }
        $user = $retailer->user;
        $stripe_manager = new StripeManager();
        $description = 'Retailer account: '.$retailer->name;
        $customer_create_res = $stripe_manager->createCustomer($user->name,$user->email,$description);
        if($customer_create_res['error'] == 1){
            return json_encode([
                'error' => 1,
                'message' => $customer_create_res['message'],
                'client_secret' => null
            ]);
        }
        $stripe_customer_id = $customer_create_res['customer_id'];
        if($intent_type == 'sepa'){
            $sepa_intent_res = $stripe_manager->setupIntentSepa($stripe_customer_id);
            if($sepa_intent_res['error'] == 1){
                return json_encode([
                    'error' => 1,
                    'message' => $sepa_intent_res['message'],
                    'client_secret' => null
                ]);
            }
            //update retailer customer id
            $retailer->stripe_customer_id = $stripe_customer_id;
            $retailer->save();
            $client_secret = $sepa_intent_res['client_secret'];
            return json_encode([
                'error' => 0,
                'message' => 'Customer account created',
                'client_secret' => $client_secret
            ]);
        }
        return json_encode([
            'error' => 1,
            'message' => 'This intent type is not being processed yet in the system',
            'client_secret' => null
        ]);
    }

    public function PaymentIntentUpdateWebhook(Request $request){
        \Log::info('Stripe Payment Intent update');
        $update_type = $request->get('type');
        $data = $request->get('data');
        $data_object = $data['object'];
        $payment_intent_id = $data_object['id'];
        //Check if payment id is available in payment logs
        $payment_log = StripePaymentLog::where('operation_id','=',$payment_intent_id)->first();
        if($payment_log!=null) {
            \Log::info(json_encode($request->all()));
            $status = $data_object['status'];
            $entity_type = $payment_log->model_name;
            $entity_id = $payment_log->model_id;
            if ($update_type == 'payment_intent.processing') {
                $payment_log->status = $status;
            } elseif ($update_type == 'payment_intent.succeeded') {
                $payment_log->status = $status;
                if($entity_type == 'retailer'){
                    //Update retailer orders
                    $retailer = Retailer::find($entity_id);
                    if($retailer!=null) {
                        $startOfMonth = Carbon::now()->startOfMonth()->subMonth()->startOfMonth()->toDateTimeString();
                        $endOfMonth = Carbon::now()->startOfMonth()->subMonth()->endOfMonth()->toDateTimeString();
                        $retailer_orders = $retailer->orders->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                            ->where('status', 'delivered')->where('is_archived', 0)->where('is_paidout_retailer', false);
                        foreach ($retailer_orders as $order) {
                            $order->is_archived = 1;
                            $order->is_paidout_retailer = true;
                            $order->save();
                        }
                    }
                }
            } elseif ($update_type == 'payment_intent.payment_failed') {
                $payment_log->status = $status;
            } elseif ($update_type == 'payment_intent.requires_action') {
                $payment_log->status = $status;
            } elseif ($update_type == 'payment_intent.partially_funded') {
                $payment_log->status = $status;
            } elseif ($update_type == 'payment_intent.canceled') {
                $payment_log->status = $status;
            } else {
                \Log::warning('Unknown/Unhandled event type: ' . $update_type);
            }
            $payment_log->save();
        } else {
            \Log::info('The payment intent was not found: ' . $payment_intent_id);
        }
        return response()->json('Webhook received successfully');
    }
}
