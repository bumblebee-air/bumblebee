<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Helpers\SecurityHelper;
use App\KPITimestamp;
use App\Managers\StripeManager;
use App\Order;
use App\User;
use App\UserClient;
use App\UserFirebaseToken;
use App\UserPasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Twilio\Rest\Client;

class DriversController extends Controller
{
    public function driversLogin(Request $request){
        $phone = $request->get('phone');
        $password = $request->get('password');
        if($phone==null || $password==null){
            $response = [
                'access_token' => '',
                'message' => 'Missing phone or password',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $the_user = User::where('phone','=',$phone)->first();
        if(!$the_user){
//            throw new BadRequestException('test');

            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
        $pass_check = password_verify($password,$the_user->password);
        if(!$pass_check){
            $response = [
                'access_token' => '',
                'message' => 'Incorrect password',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(401);
        }
        if ($request->firebase_token) {
            //Check if token registered before with another user and delete them
            UserFirebaseToken::where('token', $request->firebase_token)->where('user_id', '!=', $the_user->id)->delete();
            //Check if token registered with the same user
            $checkIfUserTokenRegistered = UserFirebaseToken::where('token', $request->firebase_token)->where('user_id', $the_user->id)->first();
            if (!$checkIfUserTokenRegistered) {
                UserFirebaseToken::create([
                    'user_id' => $the_user->id,
                    'token' => $request->firebase_token
                ]);
            }
        }
        $access_token = $the_user->createToken('PAT');
        $response = [
            'access_token' => $access_token->accessToken,
            'token_type' => 'Bearer ',
            'user_name' => $the_user->name,
            'is_profile_completed' => $the_user->is_profile_completed,
            'message' => 'Login successful',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function ordersList(){
        $current_driver = \Auth::user();
        $driver_id = $current_driver->id;
        $available_orders = Order::whereNotIn('status',['pending','delivered'])->whereNull('driver')->get()->toArray();
        $driver_orders = Order::where('status','!=','delivered')->where('driver','=',(string)$driver_id)->get()->toArray();
        $response = [
            'available_orders' => $available_orders,
            'driver_orders' => $driver_orders,
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateOrderDriverStatus(Request $request){
        $order_id = $request->get('order_id');
        $status = $request->get('status');
        $order = Order::find($order_id);
        if(!$order){
            $response = [
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        $timestamps = KPITimestamp::where('model','=','order')
            ->where('model_id','=',$order->id)->first();
        if(!$timestamps){
            $timestamps = new KPITimestamp();
            $timestamps->model = 'order';
            $timestamps->model_id = $order->id;
        }
        $current_timestamp = Carbon::now();
        $current_timestamp = $current_timestamp->toDateTimeString();
        $current_driver = \Auth::user();
        $driver_id = $current_driver->id;
        if($status!='accepted' && $status!='rejected'){
            if($order->driver != (string)$driver_id){
                $response = [
                    'message' => 'This order does not belong to this driver',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(403);
            }
            $order->driver_status = $status;
            if ($status=='on_route_pickup') {
                $order->status = $status;
                $timestamps->on_the_way_first = $current_timestamp;
            } elseif ($status=='picked_up') {
                $order->status = $status;
                $timestamps->arrived_first = $current_timestamp;
            } elseif ($status=='on_route') {
                $order->status = $status;
                $timestamps->on_the_way_second = $current_timestamp;
                //Send the customer order url for tracking & qr code
                $order->customer_confirmation_code = Str::random(8);
                $order->delivery_confirmation_code = Str::random(32);
                $retailer_name = $order->retailer_name;
                $sid    = env('TWILIO_SID', '');
                $token  = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                //url('customer/delivery_confirmation/' . $order->customer_confirmation_code)
                $twilio->messages->create($order->customer_phone,
                    [
                        "from" => "DoOrder",
                        "body" => "Hi $order->customer_name, your order from $retailer_name is on its way, open the link to track it and confirm the delivery afterwards. " . url('customer/order/' . $order->customer_confirmation_code)
                    ]
                );
            } elseif($status=='delivery_arrived'){
                $order->status = $status;
                $timestamps->arrived_second = $current_timestamp;
            }
            $order->save();
            if ($status!='delivery_arrived') {
                Redis::publish('doorder-channel', json_encode([
                    'event' => 'update-order-status',
                    'data' => [
                        'id' => $order->id,
                        'status' => $order->status,
                        'driver' => $order->orderDriver ? $order->orderDriver->name : null,
                    ]
                ]));
            }
            $response = [
                'message' => 'The order\'s status has been updated successfully',
                'delivery_confirmation_code' => $status == 'delivery_arrived' ? $order->delivery_confirmation_code : null,
                'error' => 0
            ];
            return response()->json($response)->setStatusCode(200);
        } else {
            if($status=='accepted'){
                if($order->driver!=null && $order->driver!=$driver_id){
                    $response = [
                        'message' => 'This order has already been accepted by another driver',
                        'error' => 1
                    ];
                    return response()->json($response)->setStatusCode(403);
                }
                $order->status = 'matched';
                $order->driver = $driver_id;
                $order->driver_status = $status;
                $timestamps->accepted = $current_timestamp;
                if($timestamps->assigned == null){
                    $timestamps->assigned = $current_timestamp;
                }
            }elseif($status=='rejected'){
                if($order->driver != (string)$driver_id){
                    $response = [
                        'message' => 'This order does not belong to this driver',
                        'error' => 1
                    ];
                    return response()->json($response)->setStatusCode(403);
                }
                $order->status = 'ready';
                $order->driver = null;
                $order->driver_status = null;
            }
            $order->save();
            $timestamps->save();
            Redis::publish('doorder-channel', json_encode([
                'event' => 'update-order-status',
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'driver' => $order->orderDriver ? $order->orderDriver->name : null,
                ]
            ]));
            $response = [
                'message' => 'The order\'s status has been updated successfully',
                'error' => 0
            ];
            return response()->json($response)->setStatusCode(200);
        }
    }

    public function orderDetails(Request $request){
        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        if(!$order){
            $response = [
                'order' => [],
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }

        $createdAt = $order->created_at ;
        $now = date("Y-m-d H:i:s");
        $plus24H = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($createdAt)));
        $order['remainHours'] = (int)((strtotime($plus24H) - strtotime($now) ) / (60*60));

        $order = json_decode(json_encode($order),true);

        $response = [
            'order' => $order,
            'message' => 'Order retrieved successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateDriverLocation(Request $request){
        $current_user = \Auth::user();
        $driver_id = $current_user->id;
        $coordinates = $request->get('coordinates');
        $driver_profile = DriverProfile::where('user_id','=',$driver_id)->first();
        if(!$driver_profile){
            $driver_profile = new DriverProfile();
            $driver_profile->user_id = $driver_id;
        }
        $driver_profile->latest_coordinates = json_encode($coordinates);
        $current_timestamp = Carbon::now();
        $driver_profile->coordinates_updated_at = $current_timestamp->toDateTimeString();
        $driver_profile->save();
        $lat = $coordinates['lat'];
        $lon = $coordinates['lng'];
        Redis::publish('doorder-channel', json_encode([
            'event' => 'update-driver-location',
            'data' => [
                'driver_id' => $driver_id,
                'driver_name' => $current_user->name,
                'lat' => $lat,
                'lon' => $lon,
                'timestamp' => $current_timestamp->format('H:i')
            ]
        ]));
        $response = [
            'message' => 'Driver coordinates updated successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function skipDeliveryConfirmation(Request $request) {
        $skip_reason = $request->get('skip_reason');
        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        $timestamps = KPITimestamp::where('model','=','order')
            ->where('model_id','=',$order->id)->first();
        $current_timestamp = Carbon::now();
        if (!$order) {
            $response = [
                'order' => [],
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        $order->delivery_confirmation_status = 'skipped'; # skipped || confirmed
        $order->delivery_confirmation_skip_reason = $skip_reason;
        $order->status = 'delivered';
        $timestamps->completed = $current_timestamp->toDateTimeString();
        $order->save();
        $timestamps->save();

        Redis::publish('doorder-channel', json_encode([
            'event' => 'new-order',
            'data' => [
                'id' => $order->id,
                'time' => $order->created_at->format('h:i'),
                'order_id' => $order->order_id,
                'retailer_name' => $order->retailer_name,
                'status' => $order->status,
                'driver' => $order->orderDriver ? $order->orderDriver->name : 'N/A',
                'pickup_address' => $order->pickup_address,
                'customer_address' => $order->customer_address,
                'created_at' => $order->created_at,
            ]
        ]));

        $response = [
            'message' => 'Delivery confirmation skipped successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateDriverFirebaseToken(Request $request) {
        $the_user = auth()->user();
        //Check if token registered before with another user and delete them
        UserFirebaseToken::where('token', $request->firebase_token)->where('user_id', '!=', $the_user->id)->delete();
        //Check if token registered with the same user
        $checkIfUserTokenRegistered = UserFirebaseToken::where('token', $request->firebase_token)->where('user_id', $the_user->id)->first();
        if (!$checkIfUserTokenRegistered) {
            UserFirebaseToken::create([
                'user_id' => $the_user->id,
                'token' => $request->firebase_token
            ]);
        }
        return response()->json([
            'message' => 'Token has been updated successfully'
        ]);
    }

    public function getDriverRegistration() {
        return view('doorder.drivers.registration');
    }

    public function postDriverRegistration(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users,phone',
            'contact_through' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'pps_number' => 'required',
            'emergency_contact_name' => 'required',
            'emergency_contact_number' => 'required',
            'transport_type' => 'required',
            'max_package_size' => 'required',
            'work_location' => 'required',
            'proof_id' => 'required',
            'proof_address' => 'required',
        ]);

        $user = new User();
        $user->name = "$request->first_name $request->last_name";
        $user->email = $request->email;
        $user->phone = $request->phone_number;
        $user->password = bcrypt(Str::random(6));
        $user->user_role = 'driver';
        $user->save();

        $client = \App\Client::where('name', 'DoOrder')->first();
        if($client) {
            //Making Client Relation
            UserClient::create([
                'user_id' => $user->id,
                'client_id' => $client->id
            ]);
        }

        $profile = new DriverProfile();
        $profile->user_id = $user->id;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->contact_channel = $request->contact_through;
        $profile->dob = $request->birthdate;
        $profile->address = $request->address;
        $profile->address_coordinates = $request->address_coordinates;
        $profile->pps_number = $request->pps_number;
        $profile->emergency_contact_name = $request->emergency_contact_name;
        $profile->emergency_contact_number = $request->emergency_contact_number;
        $profile->transport = $request->transport_type;
        $profile->max_package_size = $request->max_package_size;
        $profile->work_location = $request->work_location ? $request->work_location : '{"name":"N/A","coordinates":{"lat":"0","lng":"0"}}';
        $profile->legal_word_evidence = $request->proof_id ? $request->file('proof_id')->store('uploads/doorder_drivers_registration') : null;
        $profile->driver_license = $request->proof_driving_license ? $request->file('proof_driving_license')->store('uploads/doorder_drivers_registration') : null;
        $profile->driver_license_back = $request->proof_driving_license_back ? $request->file('proof_driving_license_back')->store('uploads/doorder_drivers_registration') : null;
        $profile->address_proof = $request->proof_address ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;
        $profile->insurance_proof = $request->proof_insurance ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;
        $profile->save();

        $stripe_manager = new StripeManager();
        $stripe_account = $stripe_manager->createCustomAccount($user);
        alert()->success('Your profile has been registered successfully, the administration will review your request soon');

        return redirect()->back();
    }

    public function getDriverRegistrationRequests()
    {
        $drivers_requests = DriverProfile::with('user')
//            ->where('is_confirmed', false)
//            ->whereNull('rejection_reason')
            ->paginate(20);
        return view('admin.doorder.drivers.requests', ['drivers_requests' => $drivers_requests]);
    }

    public function getSingleRequest($client_name,$id) {
        $singleRequest = DriverProfile::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        return view('admin.doorder.drivers.single_request', ['singleRequest' => $singleRequest]);
    }

    public function postSingleRequest($client_name,$id, Request $request) {
        $singleRequest = DriverProfile::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        $user = User::find($singleRequest->user_id);
        if (!$user) {
            abort(404);
        }
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Deliverer rejected successfully');
        } else {
            $singleRequest->status = 'completed';
            $singleRequest->is_confirmed = true;
            $singleRequest->save();
            //update user password send sms to deliverer with login details
            $new_pass = Str::random(6);
            $user->password = bcrypt($new_pass);
            $user->save();
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $twilio->messages->create($user->phone,
                    [
                        "from" => "DoOrder",
                        "body" => "Hi $user->name, your deliverer profile has been accepted.
                        Your login details are your phone and the password: $new_pass .
                        Login page: ".url('driver_app')
                    ]
                );
            } catch (\Exception $exception){
            }
            alert()->success('Deliverer accepted successfully');
        }
        return redirect()->route('doorder_drivers_requests', 'doorder');
    }

    public function sendForgotPasswordCode(Request $request) {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            //$resetPasswordCode = Str::random(6);
            $rand_code = rand(100000,999999);
            $resetPasswordCode = strval($rand_code);
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $twilio->messages->create($checkIfUserExists->phone,
                    [
                        "from" => "DoOrder",
                        "body" => "Hi $checkIfUserExists->name, this message has been sent upon you request.".
                        "This is your reset password code: " . $resetPasswordCode
                    ]
                );
            } catch (\Exception $exception) {
            }

            UserPasswordReset::create([
                'user_id' => $checkIfUserExists->id,
                'code' => $resetPasswordCode
            ]);
            $response = [
                'access_token' => '',
                'message' => 'Please enter the reset password code.',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }

    public function checkForgotPasswordCode(Request $request) {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->
                where('code', $request->password_reset_code)->first();
            if (!$userResetCode) {
                $response = [
                    'access_token' => '',
                    'message' => 'password reset code was not correct.',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            $response = [
                'access_token' => '',
                'message' => '',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }

    public function changeUserPassword(Request $request) {
        if(!$request->password_reset_code || !$request->password || !$request->phone){
            $response = [
                'access_token' => '',
                'message' => 'Missing password or reset code',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->
            where('code', $request->password_reset_code)->first();
            if (!$userResetCode) {
                $response = [
                    'access_token' => '',
                    'message' => 'password reset code was not correct.',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            $checkIfUserExists->update([
                'password' => bcrypt($request->password)
            ]);
            //Delete password reset codes
            UserPasswordReset::where('user_id', $checkIfUserExists->id)->delete();
            $response = [
                'access_token' => '',
                'message' => 'Password has been changed successfully',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }
    
    public function getDrivers(){
        $drivers = DriverProfile::with('user')
                    ->where('is_confirmed', true)
        //            ->whereNull('rejection_reason')
        ->paginate(20);
        return view('admin.doorder.drivers.accepted_drivers', ['drivers' => $drivers]);
    }
    public function deleteDriver(Request $request){
        // dd($request->driverId);
        $driver_id = $request->get('driverId');
        $driver_profile = DriverProfile::find($driver_id);
        if(!$driver_profile){
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        $user_account = User::find($driver_profile->user_id);
        if(!$user_account){
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        //delete user and driver entries
        $driver_profile->delete();
        $user_account->delete();
        alert()->success('Deliverer deleted successfully');
        
        return redirect()->route('doorder_drivers', 'doorder');
    }
    public function getSingleDriver($client_name,$id) {
        $driver = DriverProfile::find($id);
        //dd($driver);
        if (!$driver) {
            //abort(404);
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.drivers.single_driver', ['driver' => $driver,'readOnly'=>0]);
    }
    public function getViewDriver($client_name,$id) {
        $driver = DriverProfile::find($id);
        //dd($driver);
        if (!$driver) {
            //abort(404);
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.drivers.single_driver', ['driver' => $driver,'readOnly'=>true]);
    }
    
    public function saveUpdateDriver($client_name,$id, Request $request) {
        //dd($request->all());
        $driver_id = $request->get('driver_id');
        $profile = DriverProfile::find($driver_id);
        if(!$profile) {
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        $profile->first_name = $request->get('first_name');
        $profile->last_name = $request->get('last_name');
        $profile->contact_channel = $request->get('contact_channel');
        $profile->dob = $request->get('birthdate');
        $profile->address = $request->get('address');
        //$profile->address_coordinates = $request->get('address_coordinates');
        $profile->country = $request->get('country');
        $profile->postcode = $request->get('postcode');
        $profile->pps_number = $request->get('pps_number');
        $profile->emergency_contact_name = $request->get('emergency_contact_name');
        $profile->emergency_contact_number = $request->get('emergency_contact_number');
        $profile->transport = $request->get('transport');
        $profile->max_package_size = $request->get('max_package_size');
        $profile->work_radius = $request->get('work_radius');
        if($request->get('working_days_hours')!=null) {
            $profile->business_hours = $request->get('working_days_hours');
        }
        //$profile->work_location = $request->get('work_location')!=null ? $request->get('work_location') : '{"name":"N/A","coordinates":{"lat":"0","lng":"0"}}';
        /*$profile->legal_word_evidence = $request->proof_id ? $request->file('proof_id')->store('uploads/doorder_drivers_registration') : null;
        $profile->driver_license = $request->proof_driving_license ? $request->file('proof_driving_license')->store('uploads/doorder_drivers_registration') : null;
        $profile->driver_license_back = $request->proof_driving_license_back ? $request->file('proof_driving_license_back')->store('uploads/doorder_drivers_registration') : null;
        $profile->address_proof = $request->proof_address ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;
        $profile->insurance_proof = $request->proof_insurance ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;*/
        $profile->save();

        alert()->success('Deliverer updated successfully');
        //alert()->success('Work in progress');

        return redirect()->route('doorder_drivers', 'doorder');
    }

    public function changePassword(Request $request) {
        $errors = \Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }

        if (password_verify($request->old_password, auth()->user()->password)) {
            User::find(auth()->user()->id)->update([
                'password' => bcrypt($request->new_password)
            ]);
            return response()->json([
                'errors' => 0,
                'message' => 'Your password has changed successfully'
            ]);
        } else {
            return response()->json([
                'errors' => 1,
                'message' => 'The old password is not matched.'
            ], 403);
        }
    }

    public function updateProfile(Request $request) {
        $errors = \Validator::make($request->all(), [
            'business_hours' => 'required',
            'business_hours_json' => 'required',
            'name' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }
        //Update User Name
        $user =  User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->is_profile_completed = true;
        $user->save();
        //Update User profile
        $driver = DriverProfile::where('user_id', $user->id)->first();
        $name_split = explode(' ',$request->name);
        $driver->first_name = $name_split[0];
        $driver->last_name = isset($name_split[1])? $name_split[1] : '';
        $driver->business_hours = $request->business_hours;
        $driver->save();
        //return json response
        return response()->json([
            'errors' => 0,
            'message' => 'Your profile has updated successfully.'
        ]);
    }

    public function getProfile(Request $request) {
        $driver = DriverProfile::where('user_id', auth()->user()->id)->first();
        return response()->json([
            'errors' => 0,
            'data' => [
                'full_name' => auth()->user()->name,
                'phone' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'business_hours' => $driver->business_hours,
                'business_hours_json' => $driver->business_hours_json,
            ]
        ]);
    }
}
