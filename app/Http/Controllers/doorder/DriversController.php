<?php

namespace App\Http\Controllers\doorder;

use App\Contractor;
use App\DriverProfile;
use App\Exports\DriversExport;
use App\GeneralSetting;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\SecurityHelper;
use App\Helpers\TwilioHelper;
use App\KPITimestamp;
use App\Managers\StripeManager;
use App\Order;
use App\Retailer;
use App\User;
use App\UserClient;
use App\UserFirebaseToken;
use App\UserPasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rating;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Twilio\Rest\Client;
use Maatwebsite\Excel\Facades\Excel;

class DriversController extends Controller
{
    public function driversLogin(Request $request)
    {
        $phone = $request->get('phone');
        $password = $request->get('password');
        if ($phone == null || $password == null) {
            $response = [
                'access_token' => '',
                'message' => 'Missing phone or password',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $the_user = User::where('phone', '=', $phone)->first();
        if (!$the_user) {
            //            throw new BadRequestException('test');

            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
        $pass_check = password_verify($password, $the_user->password);
        if (!$pass_check) {
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
            'in_duty' => $the_user->driver_profile->in_duty,
            'is_profile_completed' => $the_user->is_profile_completed,
            'message' => 'Login successful',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function ordersList()
    {
        $current_driver = \Auth::user();
        $driver_id = $current_driver->id;
        //$available_orders = Order::whereNotIn('status',['pending','delivered'])->whereNull('driver')->get()->toArray();
        $available_orders = [];
        $driver_orders = Order::where('status', '!=', 'delivered')->where('status', '!=', 'not_delivered')->where('driver', '=', (string)$driver_id)->get();
        foreach ($driver_orders as $driver_order) {
            $retailer = Retailer::find($driver_order->retailer_id);
            $retailer_number = 'N/A';
            if ($retailer != null) {
                $contact_details = json_decode($retailer->contacts_details);
                $main_contact = $contact_details[0];
                $retailer_number = $main_contact->contact_phone;
            }
            $driver_order->retailer_phone = $retailer_number;
        }
        $driver_orders = $driver_orders->toArray();
        $response = [
            'available_orders' => $available_orders,
            'driver_orders' => $driver_orders,
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateOrderDriverStatus(Request $request)
    {
        $order_id = $request->get('order_id');
        $status = $request->get('status');
        $order = Order::find($order_id);
        if (!$order) {
            $response = [
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        $timestamps = KPITimestamp::where('model', '=', 'order')
            ->where('model_id', '=', $order->id)->first();
        if (!$timestamps) {
            $timestamps = new KPITimestamp();
            $timestamps->model = 'order';
            $timestamps->model_id = $order->id;
        }
        $current_timestamp = Carbon::now();
        $current_timestamp = $current_timestamp->toDateTimeString();
        $current_driver = \Auth::user();
        $driver_id = $current_driver->id;
        if ($status != 'accepted' && $status != 'rejected') {
            if ($order->driver != (string)$driver_id) {
                $response = [
                    'message' => 'This order does not belong to this driver',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(403);
            }
            $order->driver_status = $status;
            if ($status == 'on_route_pickup') {
                $order->status = $status;
                $timestamps->on_the_way_first = $current_timestamp;
            } elseif ($status == 'picked_up') {
                $order->status = $status;
                $timestamps->arrived_first = $current_timestamp;
            } elseif ($status == 'on_route') {
                $order->status = $status;
                $timestamps->on_the_way_second = $current_timestamp;
                //Send the customer order url for tracking & qr code
                $order->customer_confirmation_code = Str::random(8);
                $order->delivery_confirmation_code = Str::random(32);
                $retailer_name = $order->retailer_name;
                try {
                    $sid = env('TWILIO_SID', '');
                    $token = env('TWILIO_AUTH', '');
                    $twilio = new Client($sid, $token);
                    //url('customer/delivery_confirmation/' . $order->customer_confirmation_code)
                    $sender_name = "DoOrder";
                    foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                        if (strpos($order->customer_phone, $country_code) !== false) {
                            $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                        }
                    }
                    $twilio->messages->create(
                        $order->customer_phone,
                        [
                            "from" => $sender_name,
                            "body" => "Hi $order->customer_name, DoOrder’s same day delivery service has your order and its on its way, open the link to track it and confirm the delivery afterwards. " . url('customer/order/' . $order->customer_confirmation_code)
                        ]
                    );
                } catch (\Exception $exception) {
                    \Log::error($exception->getMessage());
                }
            } elseif ($status == 'delivery_arrived') {
                $order->status = $status;
                $timestamps->arrived_second = $current_timestamp;
                CustomNotificationHelper::send('order_completed', $order->id);
            }
            $order->save();
            $timestamps->save();
            Redis::publish('doorder-channel', json_encode([
                'event' => 'update-order-status' . '-' . env('APP_ENV', 'dev'),
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'driver' => $order->orderDriver ? $order->orderDriver->name : null,
                ]
            ]));
            $response = [
                'message' => 'The order\'s status has been updated successfully',
                'delivery_confirmation_code' => $status == 'delivery_arrived' ? $order->delivery_confirmation_code : null,
                'error' => 0
            ];
            return response()->json($response)->setStatusCode(200);
        } else {
            if ($status == 'accepted') {
                if ($order->driver != null && $order->driver != $driver_id) {
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
                if ($timestamps->assigned == null) {
                    $timestamps->assigned = $current_timestamp;
                }
            } elseif ($status == 'rejected') {
                if ($order->driver != (string)$driver_id) {
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
                'event' => 'update-order-status' . '-' . env('APP_ENV', 'dev'),
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
    public function AddDriverRating(Request $request)
    {
        $message = "Done";
        $code = 200;
        $data = [];
        try {
            $current_driver = \Auth::user();
            Rating::updateOrCreate(
                [
                    'model' => 'doorder',
                    'model_id' => 1,
                    'user_type' => 'driver',
                    'user_id' => $current_driver->id
                ],
                [
                    'model' => 'doorder',
                    'model_id' => 1,
                    'user_type' => 'driver',
                    'user_id' => $current_driver->id,
                    'rating' => $request->rating,
                    'message' => $request->message,
                ]
            );
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $code = 400;
        }
        $response = [
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response)->setStatusCode($code);
    }
    public function updateDriverDutyStatus(Request $request)
    {
        $message = "Done";
        $code = 200;
        $data = [];
        try {
            $current_driver = \Auth::user();
            DriverProfile::where('user_id', $current_driver->id)->update(['in_duty' => $request->in_duty, 'last_active' => now()]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $code = 400;
        }
        $response = [
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response)->setStatusCode($code);
    }
    public function timeEndShift(Request $request)
    {
        $message = "Done";
        $code = 200;
        $data = [];
        try {
            $settings = GeneralSetting::firstOrCreate([]);
            $data = ['time' => $settings->driversTimeEndShift];
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            $code = 400;
        }
        $response = [
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response)->setStatusCode($code);
    }

    public function orderDetails(Request $request)
    {
        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        if (!$order) {
            $response = [
                'order' => [],
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        $retailer = Retailer::find($order->retailer_id);
        $retailer_number = 'N/A';
        if ($retailer != null) {
            $contact_details = json_decode($retailer->contacts_details);
            $main_contact = $contact_details[0];
            $retailer_number = $main_contact->contact_phone;
        }
        $order->retailer_phone = $retailer_number;
        $createdAt = $order->created_at;
        $now = date("Y-m-d H:i:s");
        $plus24H = date("Y-m-d H:i:s", strtotime('+24 hours', strtotime($createdAt)));
        $order['remainHours'] = (int)((strtotime($plus24H) - strtotime($now)) / (60 * 60));

        $order = json_decode(json_encode($order), true);

        $response = [
            'order' => $order,
            'message' => 'Order retrieved successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateDriverLocation(Request $request)
    {
        $current_user = \Auth::user();
        $driver_id = $current_user->id;
        $coordinates = $request->get('coordinates');
        //Check for these parameters if present to use instead
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        if ($lat != null && $lat != '' && $lng != null && $lng != '') {
            $coordinates = ['lat' => $lat, 'lng' => $lng];
        } else {
            $response = [
                'message' => 'Coordinates are missing!',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
        $driver_profile = DriverProfile::where('user_id', '=', $driver_id)->first();
        if (!$driver_profile) {
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
            'event' => 'update-driver-location' . '-' . env('APP_ENV', 'dev'),
            'data' => [
                'driver_id' => $driver_id,
                'driver_name' => $current_user->name,
                'lat' => $lat,
                'lon' => $lon,
                'timestamp' => $current_timestamp->format('d M H:i')
            ]
        ]));
        $response = [
            'message' => 'Driver coordinates updated successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function skipDeliveryConfirmation(Request $request)
    {
        $skip_reason = $request->get('skip_reason');
        $order_id = $request->get('order_id');
        $order = Order::find($order_id);
        $timestamps = KPITimestamp::where('model', '=', 'order')
            ->where('model_id', '=', $order->id)->first();
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
        /*Redis::publish('doorder-channel', json_encode([
            'event' => 'new-order'.'-'.env('APP_ENV','dev'),
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
        ]));*/
        //Send driver rating SMS to customer and retailer
        $msg_content = "Hi $order->customer_name , thank you for selecting DoOrder delivery, you can" .
            " rate your deliverer through the link: " . url('doorder/order/rating/2/' . $order_id);
        TwilioHelper::sendSMS('DoOrder', $order->customer_phone, $msg_content);
        $retailer = Retailer::find($order->retailer_id);
        $retailer_number = 'N/A';
        if ($retailer != null) {
            $contact_details = json_decode($retailer->contacts_details);
            $main_contact = $contact_details[0];
            $retailer_number = $main_contact->contact_phone;
        }
        $general_setting = GeneralSetting::first();
        if ($retailer_number != 'N/A') {
            $msg_content = "Hi $retailer->name , the order no. $order->order_id has been delivered, you can" .
                " rate your deliverer through the link: " . url('doorder/order/rating/1/' . $order_id);
            if ($general_setting) {
                if ($general_setting->retailers_automatic_rating_sms) {
                    TwilioHelper::sendSMS('DoOrder', $retailer_number, $msg_content);
                }
            } else {
                TwilioHelper::sendSMS('DoOrder', $retailer_number, $msg_content);
            }
        }
        $response = [
            'message' => 'Delivery confirmation skipped successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateDriverFirebaseToken(Request $request)
    {
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

    public function getDriverRegistration()
    {
        return view('doorder.drivers.registration');
    }

    public function postDriverRegistration(Request $request)
    {
        $request_url = $request->url();
        try {
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
        } catch (ValidationException $e) {
            if (strpos($request_url, 'api/') !== false) {
                $error_string = 'The following inputs have errors';
                foreach ($e->errors() as $validate_err) {
                    if (is_array($validate_err)) {
                        foreach ($validate_err as $err) {
                            $error_string .= ', ' . $err;
                        }
                    } else {
                        $error_string .= ', ' . $validate_err;
                    }
                }
                $response = [
                    'message' => $error_string,
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            } else {
                $error_html = '<h3>The following inputs have errors</h3> <p><ul>';
                foreach ($e->errors() as $validate_err) {
                    if (is_array($validate_err)) {
                        foreach ($validate_err as $err) {
                            $error_html .= '<li>' . $err . '</li>';
                        }
                    } else {
                        $error_html .= '<li>' . $validate_err . '</li>';
                    }
                }
                $error_html .= '</ul></p>';
                alert()->error($error_html);
                return redirect()->back()->withInput();
            }
        }

        try {
            $user = new User();
            $user->name = "$request->first_name $request->last_name";
            $user->email = $request->email;
            $user->phone = $request->phone_number;
            $user->password = bcrypt(Str::random(6));
            $user->user_role = 'driver';
            $user->save();
        } catch (\Exception $exception) {
            $response = [
                'message' => $exception->getMessage(),
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $client = \App\Client::where('name', 'DoOrder')->first();
        if ($client) {
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
        CustomNotificationHelper::send('new_deliverer', $profile->id);
        if (strpos($request_url, 'api/') !== false) {
            $response = [
                'message' => 'Your profile has been registered successfully, the administration will review your request soon',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            alert()->success('Your profile has been registered successfully, the administration will review your request soon');
        }
        return redirect()->back();
    }

    public function getDriverRegistrationRequests()
    {
        $drivers_requests = DriverProfile::with('user')
            ->orderBy('created_at', 'desc')->paginate(20);
        //->where('is_confirmed', false)->whereNull('rejection_reason')
        return view('admin.doorder.drivers.requests', ['drivers_requests' => $drivers_requests]);
    }

    public function getSingleRequest($client_name, $id)
    {
        $singleRequest = DriverProfile::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        return view('admin.doorder.drivers.single_request', ['singleRequest' => $singleRequest]);
    }

    public function postSingleRequest($client_name, $id, Request $request)
    {
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
                $sender_name = "DoOrder";
                foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                    if (strpos($user->phone, $country_code) !== false) {
                        $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                    }
                }
                $twilio->messages->create(
                    $user->phone,
                    [
                        "from" => $sender_name,
                        "body" => "Hi $user->name, your deliverer profile has been accepted. " .
                            "Your login details are your phone and the password: $new_pass . " .
                            "Login page: " . url('driver_app')
                    ]
                );
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
            }
            alert()->success('Deliverer accepted successfully');
        }
        return redirect()->route('doorder_drivers_requests', 'doorder');
    }

    public function sendForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            //Check if deliverer profile has been completed
            $driver_profile = DriverProfile::where('user_id', '=', $checkIfUserExists->id)->first();
            if (!$driver_profile) {
                $response = [
                    'access_token' => '',
                    'message' => 'No driver profile was found',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            if ($driver_profile->is_confirmed != true) {
                $response = [
                    'access_token' => '',
                    'message' => 'Driver profile has not been accepted yet',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            //$resetPasswordCode = Str::random(6);
            $rand_code = rand(100000, 999999);
            $resetPasswordCode = strval($rand_code);
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $sender_name = "DoOrder";
                foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                    if (strpos($checkIfUserExists->phone, $country_code) !== false) {
                        $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                    }
                }
                $twilio->messages->create(
                    $checkIfUserExists->phone,
                    [
                        "from" => $sender_name,
                        "body" => "Hi $checkIfUserExists->name, this message has been sent upon a reset password request.\n" .
                            "This is your reset password code: " . $resetPasswordCode
                    ]
                );
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
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

    public function sendGHForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            //Check if deliverer profile has been completed
            $driver_profile = Contractor::where('user_id', '=', $checkIfUserExists->id)->first();
            if (!$driver_profile) {
                $response = [
                    'access_token' => '',
                    'message' => 'No contractor profile was found',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            if ($driver_profile->status != "completed") {
                $response = [
                    'access_token' => '',
                    'message' => 'Contractor profile has not been accepted yet',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            //$resetPasswordCode = Str::random(6);
            $rand_code = rand(100000, 999999);
            $resetPasswordCode = strval($rand_code);
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $sender_name = "GardenHelp";
                foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                    if (strpos($checkIfUserExists->phone, $country_code) !== false) {
                        $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                    }
                }
                $twilio->messages->create(
                    $checkIfUserExists->phone,
                    [
                        "from" => $sender_name,
                        "body" => "Hi $checkIfUserExists->name, this message has been sent upon a reset password request.\n" .
                            "This is your reset password code: " . $resetPasswordCode
                    ]
                );
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
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

    public function checkForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->where('code', $request->password_reset_code)->first();
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

    public function changeUserPassword(Request $request)
    {
        if (!$request->password_reset_code || !$request->password || !$request->phone) {
            $response = [
                'access_token' => '',
                'message' => 'Missing password or reset code',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->where('code', $request->password_reset_code)->first();
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

    public function getDrivers(Request $request)
    {
        $drivers = DriverProfile::with('user')
            ->where('is_confirmed', true)
            ->orderBy('created_at', 'desc')->get();
        //            ->whereNull('rejection_reason')->paginate(20)
        if ($request->export_type == 'exel') {
            return Excel::download(new DriversExport(['items' => $drivers]), 'drivers-report.xlsx');
        }
        foreach ($drivers as $driver) {
            $driver->overall_rating = 4;
        }

        return view('admin.doorder.drivers.accepted_drivers', ['drivers' => $drivers]);
    }
    public function deleteDriver(Request $request)
    {
        // dd($request->driverId);
        $driver_id = $request->get('driverId');
        $driver_profile = DriverProfile::find($driver_id);
        if (!$driver_profile) {
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        $user_account = User::find($driver_profile->user_id);
        if (!$user_account) {
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        //delete user and driver entries
        $driver_profile->delete();
        $user_account->delete();
        alert()->success('Deliverer deleted successfully');

        return redirect()->route('doorder_drivers', 'doorder');
    }
    public function getSingleDriver($client_name, $id)
    {
        $driver = DriverProfile::find($id);
        //dd($driver);
        if (!$driver) {
            //abort(404);
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.drivers.single_driver', ['driver' => $driver, 'readOnly' => 0]);
    }
    public function getViewDriver($client_name, $id)
    {
        $driver = DriverProfile::find($id);
        //dd($driver);
        if (!$driver) {
            //abort(404);
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.drivers.single_driver', ['driver' => $driver, 'readOnly' => true]);
    }
    public function getViewDriverAndOrders($client_name, $id)
    {
        $driver = DriverProfile::find($id);
        //dd($driver);
        if (!$driver) {
            //abort(404);
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }


        $driver_orders = Order::whereHas('rating', function ($q) {
            $q->where('model', '=', 'order');
        })->where('driver', '=', (string)$driver->user_id)->get();
        //dd($driver_orders);
        $order_ids = [];
        foreach ($driver_orders as $order) {
            $order_ids[] = $order->id;
            $order->rating_retailer = 0;
            $order->rating_customer = 0;
            if (count($order->rating) > 0) {
                //                 $order_rating = 0;
                //                 foreach($order->rating as $a_rating){
                //                     $order_rating += $a_rating->rating;
                //                 }
                //                 $driver_rating = $order_rating / count($order->rating);
                //                 //Round to nearest half decimal
                //                 $order->driver_rating = round($driver_rating * 2)/2;
                foreach ($order->rating as $a_rating) {
                    if ($a_rating->user_type == 'retailer') {
                        $order->rating_retailer = $a_rating->rating;
                    }
                    if ($a_rating->user_type == 'customer') {
                        $order->rating_customer = $a_rating->rating;
                    }
                }
            } else {
                $order->driver_rating = 0;
            }
        }
        $driver_ratings = \DB::table('ratings')->where('model', '=', 'order')
            ->whereIn('model_id', $order_ids)->selectRaw('avg(rating) as average_rating')->first();
        $driver_overall_rating = ($driver_ratings->average_rating != null) ? $driver_ratings->average_rating : 0;
        $driver->overall_rating = round($driver_overall_rating * 2) / 2;

        return view('admin.doorder.drivers.single_driver_orders', ['driver' => $driver, 'driver_orders' => $driver_orders]);
    }

    public function saveUpdateDriver($client_name, $id, Request $request)
    {
        //dd($request->all());
        $driver_id = $request->get('driver_id');
        $profile = DriverProfile::find($driver_id);
        if (!$profile) {
            alert()->error('Deliverer not found!');
            return redirect()->back();
        }
        $user = $profile->user;
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $contact_number = $request->get('contact_number');
        $email = $request->get('email');
        try {
            $user->name = $first_name . ' ' . $last_name;
            $user->email = $email;
            //dd($contact_number,$user->phone);
            if ($contact_number !== $user->phone) {
                $user->phone = $contact_number;
            }
            $user->save();
        } catch (\Exception $exception) {
            $err_msg = $exception->getMessage();
            if (str_contains($err_msg, 'users_phone_unique')) {
                alert()->error('This phone number belongs to another user on the platform');
            } else {
                alert()->error($err_msg);
            }
            return redirect()->back();
        }
        $profile->first_name = $first_name;
        $profile->last_name = $last_name;
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
        if ($request->get('working_days_hours') != null) {
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

    public function changePassword(Request $request)
    {
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

    public function updateProfile(Request $request)
    {
        $errors = \Validator::make($request->all(), [
            'business_hours' => 'required',
            'business_hours_json' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }
        //Update User Name
        $user =  User::find(auth()->user()->id);
        $first_name = '';
        $last_name = '';
        if ($request->first_name != null && $request->last_name != null) {
            $first_name = $request->first_name;
            $last_name = $request->last_name;
        } else {
            if ($request->name != null) {
                $name_split = explode(' ', $request->name);
                $first_name = $name_split[0];
                $last_name = $name_split[1] ?? '';
            }
        }
        $user->name = $first_name . ' ' . $last_name;
        $user->is_profile_completed = true;
        $user->save();
        //Update User profile
        $driver = DriverProfile::where('user_id', $user->id)->first();
        $driver->first_name = $first_name;
        $driver->last_name = $last_name;
        $driver->business_hours = $request->business_hours;
        $driver->business_hours_json = $request->business_hours_json;
        $driver->save();
        //return json response
        return response()->json([
            'errors' => 0,
            'message' => 'Your profile has updated successfully.'
        ]);
    }

    public function getProfile(Request $request)
    {
        $driver = DriverProfile::where('user_id', auth()->user()->id)->first();
        return response()->json([
            'errors' => 0,
            'data' => [
                'full_name' => auth()->user()->name,
                'first_name' => $driver->first_name,
                'last_name' => $driver->last_name,
                'phone' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'business_hours' => $driver->business_hours,
                'business_hours_json' => $driver->business_hours_json,
            ]
        ]);
    }

    public function optimizeOrdersRoute(Request $request)
    {
        $current_user = \Auth::user();
        $driver_id = $current_user->id;
        $driver_coordinates = $request->get('driver_coordinates');
        $order_ids = $request->get('order_ids');
        if ($driver_coordinates == null || $order_ids == null) {
            return response()->json([
                'errors' => 1,
                'error_msg' => 'The driver coordinates or the order IDs are missing',
                'optimized_route' => []
            ]);
        }
        //$order_ids = explode(',',$order_ids);
        $order_ids = json_decode('[' . $order_ids . ']', true);
        $orders = Order::whereIn('id', $order_ids)->get();
        $orders_data = [];
        foreach ($orders as $order) {
            if (intval($order->driver) != $driver_id) {
                return response()->json([
                    'errors' => 1,
                    'error_msg' => 'The order with ID ' . $order->id . ' doesn\'t belong to this driver!',
                    'optimized_route' => []
                ]);
            }
            $orders_data[] = [
                'order_id' => (string)$order->id,
                'pickup' => $order->pickup_lat . ',' . $order->pickup_lon,
                'dropoff' => $order->customer_address_lat . ',' . $order->customer_address_lon
            ];
        }
        $deliverers_coordinates = [];
        $deliverers_coordinates[] = ['deliverer_id' => (string)$driver_id, 'deliverer_coordinates' => $driver_coordinates];
        $route_opt_url = env('ROUTE_OPTIMIZE_URL', 'https://afternoon-lake-03061.herokuapp.com') . '/routing_table';
        $route_optimization_req = Http::post($route_opt_url, [
            'deliverers_coordinates' => json_encode($deliverers_coordinates),
            'orders_address' => json_encode($orders_data)
        ]);
        if ($route_optimization_req->status() != 200) {
            return response()->json([
                'errors' => 1,
                'error_msg' => 'The route optimization failed with the message: '
                    . $route_optimization_req->body(),
                'optimized_route' => []
            ]);
        }
        $optimized_route_resp = json_decode($route_optimization_req->body());
        $optimized_route_arr = $optimized_route_resp[0];
        //Remove the first item (driver's current coordinates)
        array_shift($optimized_route_arr);
        foreach ($optimized_route_arr as $route_item) {
            $the_order = $orders->firstWhere('id', $route_item->order_id);
            $route_item->status = ($the_order->driver_status != null) ? $the_order->driver_status : $the_order->status;
        }
        return response()->json([
            'errors' => 0,
            'error_msg' => 'The route optimization was successful',
            'optimized_route' => $optimized_route_arr
        ]);
    }
}
