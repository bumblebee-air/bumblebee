<?php
namespace App\Http\Controllers\doorder;

use App\Client;
use App\ClientSetting;
use App\CustomNotification;
use App\Http\Controllers\Controller;
use App\User;
use App\UserClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{

    public function getSettings()
    {
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        $client_setting = $the_client->setting;
        $adminsData = [];
        $callCenterOptions = [];
        $savedNotificationsData = [];
        $admins = User::where('user_role', 'client')->whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })
            ->get();
        $savedNotifications = CustomNotification::whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })->get();
        foreach ($admins as $admin) {
            $adminsData[] = [
                'id' => $admin->id,
                'label' => $admin->name,
                'customLabel' => "Admin, $admin->name"
            ];
        }
        foreach ($savedNotifications as $notification) {
            $savedNotificationsData[] = [
                'id' => $notification->id,
                'customNotification' => (bool) $notification->is_active,
                'notification_type' => $notification->type,
                'notification_name' => $notification->name,
                'notification_channel' => $notification->channel,
                'phone_number' => json_decode($notification->send_to, true),
                'email' => json_decode($notification->send_to, true),
                'user_type' => $notification->send_to,
                'notification_content' => $notification->content
            ];
        }
        
        /*$userData1 = new UserData(1, "sara", "sara@doorder.eu", "August, 24 2021", "Admin",1);
        $userData2 = new UserData(2, "sara reda", "sarareda@doorder.eu", "August, 25 2021", "Driver manager",1);
        $users=array($userData1,$userData2);*/
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        $client_users = UserClient::where('client_id',$the_client->id)->pluck('user_id')->toArray();
        $users = User::whereIn('id',$client_users)->whereNotIn('user_role',['retailer','driver','client'])->get();
        foreach($users as $user){
            if($user->user_role=='client' || $user->user_role=='admin'){
                $user->user_type = 'Admin';
            } elseif($user->user_role=='driver_manager'){
                $user->user_type = 'Driver Manager';
            } elseif($user->user_role=='investor'){
                $user->user_type = 'Investor';
            }
        }
        
        return view('admin.doorder.settings.index', [
            'adminOptions' => json_encode($adminsData),
            'callCenterOptions' => json_encode($callCenterOptions),
            'savedNotifications' => ($savedNotificationsData),
            'client_setting' => $client_setting,
            'users'=>json_encode($users)
        ]);
    }

    public function postSaveNotification(Request $request)
    {
        $this->validate($request, [
            'notification_name0' => 'required',
            'notification_type0' => 'required',
            'notification_channel0' => 'required',
            'notification_content0' => 'required',
            'customNotification0' => 'required'
        ]);
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        CustomNotification::whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })->delete();
        for ($i = 0; $i < $request->indexes; $i ++) {
            $send_to = [];
            if ($request["notification_channel$i"] == 'email' || $request["notification_channel$i"] == 'sms') {
                $contacts = $request["notification_channel$i"] == 'email' ? $request["email$i"] : $request["phone_number$i"];
                foreach ($contacts as $contact) {
                    $send_to[] = [
                        'value' => $contact
                    ];
                }
                $send_to = json_encode($send_to);
            } else {
                $send_to = $request["user_type$i"];
            }

            $customNotification = new CustomNotification();
            $customNotification->name = $request["notification_name$i"];
            $customNotification->type = $request["notification_type$i"];
            $customNotification->channel = $request["notification_channel$i"];
            $customNotification->send_to = $send_to;
            $customNotification->content = $request["notification_content$i"];
            $customNotification->client_id = $client_id;
            $customNotification->is_active = ($request["customNotification$i"] == 'true' || $request["customNotification$i"] == '1');
            $customNotification->save();
        }
        alert()->success('Notifications saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }

    public function postSaveStripeApi(Request $request)
    {
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        $client_setting = $the_client->setting;
        // dd($request->all());
        if ($request->has('retailerAutomaticCharging')) {
            $check_if_deliverer_payout_exists = $client_setting->where('name', 'day_of_retailer_charging');
            if (count($check_if_deliverer_payout_exists) > 0) {
                $deliverer_payout = $check_if_deliverer_payout_exists->first();
                $deliverer_payout->update([
                    'the_value' => $request->dayOfMonth
                ]);
            } else {
                ClientSetting::create([
                    'name' => 'day_of_retailer_charging',
                    'client_id' => $the_client->id,
                    'the_value' => $request->dayOfMonth,
                    'display_name' => 'The Schedule datetime'
                ]);
            }
        } else {
            ClientSetting::where('client_id', $the_client->id)->where('name', 'day_of_retailer_charging')->delete();
        }
        if ($request->has('delivererPayout')) {
            $check_if_deliverer_payout_exists = $client_setting->where('name', 'day_time_of_driver_charging');
            if (count($check_if_deliverer_payout_exists) > 0) {
                $deliverer_payout = $check_if_deliverer_payout_exists->first();
                $deliverer_payout->update([
                    'the_value' => "$request->weekday 00:00"
                ]);
            } else {
                ClientSetting::create([
                    'name' => 'day_time_of_driver_charging',
                    'client_id' => $the_client->id,
                    'the_value' => "$request->weekday 00:00",
                    'display_name' => 'The Schedule datetime'
                ]);
            }
        } else {
            ClientSetting::where('client_id', $the_client->id)->where('name', 'day_time_of_driver_charging')->delete();
        }
        alert()->success('Stripe settings saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
    
    public function deleteUser(Request $request){
        //dd('delete user settings '.$request->userId);
        $user_id = $request->get('userId');
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        if(!$the_client){
            alert()->error('Your user is not connected to a client, please contact the administration!');
        }
        $user_client = UserClient::where('user_id',$user_id)
            ->where('client_id',$client_id)->first();
        if(!$user_client){
            alert()->error('User does not belong to this account');
        }
        $user_client->delete();
        $user = User::find($user_id);
        $user->delete();
        alert()->success('User deleted successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
    public function saveUser(Request $request){
        //dd($request->all());
        $name = $request->get('user_name');
        $email = $request->get('email');
        $user_type = $request->get('user_type');
        $pass_pre_hash = mt_rand(100000,999999);
        $password = Hash::make($pass_pre_hash);
        $request->merge(['password'=>$password]);
        try {
            $this->userValidator($request->all())->validate();
        } catch (ValidationException $e) {
            $validation_errors = $e->errors();
            $errors_string = '';
            foreach($validation_errors as $item_errors) {
                foreach($item_errors as $item_error){
                    $errors_string .= $item_error."\r\n";
                }
            }
            alert()->error($errors_string);
            return redirect()->back();
        }
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        if(!$the_client){
            alert()->error('Your user is not connected to a client, please contact the administration!');
        }
        $new_user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'user_role' => $user_type
        ]);
        $user_client = new UserClient();
        $user_client->user_id = $new_user->id;
        $user_client->client_id = $client_id;
        $user_client->save();
        \Mail::send([], [], function ($message) use($email, $name, $pass_pre_hash) {
            $message->from('no-reply@doorder.eu', 'DoOrder platform')
                ->to($email)
                ->subject('Platform Registration')
                ->setBody("Hi $name,<br/>You have been registered on DoOrder and here are your ".
                    "login credentials:<br/><br/> <strong>Email:</strong> $email<br/> ".
                    "<strong>Password</strong>: $pass_pre_hash <br/>".
                    "You can access the platform from <a href='".url('')."'>this link</a>", 'text/html');
        });
        alert()->success('User added successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
    
    public function editUser(Request $request){
        //dd($request->all());
        $user_id = $request->get('userId');
        $name = $request->get('user_name');
        $email = $request->get('email');
        $user_role = $request->get('user_type');
        $user = User::find($user_id);
        if(!$user){
            alert()->error('This user was not found!');
        }
        $user->name = $name;
        $user->email = $email;
        $user->user_role = $user_role;
        if($user->isDirty()){
            $validation_rules = [];
            $validation_rules['user_name'] = ['required', 'string', 'max:255'];
            $validation_rules['email'] = ['required', 'string', 'email', 'max:255'];
            if($user->getOriginal('email')!=$email){
                $validation_rules['email'][] = 'unique:users';
            }
            $user_validator = Validator::make($request->all(),$validation_rules,[
                'user_name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'The email format is not valid',
                'email.unique' => 'Email is already taken',
                'password.required' => 'Password is required'
            ]);
            if($user_validator->fails()){
                return redirect()->back()->withErrors($user_validator);
            }
            $user->save();
            alert()->success('User was updated successfully');
            return redirect()->back();
        }
        alert()->success('No user data was changed');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
    
    public function postSaveGeneralSettings(Request $request){
        //dd($request);
        alert()->success('General settings data updated successfully');
        return redirect()->back();
    }

    protected function userValidator(array $data){
        return Validator::make($data, [
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ],[
            'user_name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'The email format is not valid',
            'email.unique' => 'Email is already taken',
            'password.required' => 'Password is required'
        ]);
    }
}

/*class UserData
{

    public $id, $name, $email, $lastActivity, $userType,$userTypeId;

    public function __construct($id, $name, $email, $lastActivity, $userType,$userTypeId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->lastActivity = $lastActivity;
        $this->userType = $userType;
        $this->userTypeId = $userTypeId;
    }
}*/