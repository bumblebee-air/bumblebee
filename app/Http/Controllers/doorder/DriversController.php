<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Helpers\SecurityHelper;
use App\KPITimestamp;
use App\Order;
use App\User;
use App\UserFirebaseToken;
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
        $available_orders = Order::where('status','!=','delivered')->whereNull('driver')->get()->toArray();
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
            if($status=='delivery_arrived'){
//                $order->status = $status;
//                $order->customer_confirmation_code = Str::random(8);
//                $order->delivery_confirmation_code = Str::random(32);
                /*
                 * Sending the confirmation URL to Customer is here
                 */

                $sid    = env('TWILIO_SID', '');
                $token  = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $twilio->messages->create($order->customer_phone,
                    [
                        "from" => "DoOrder",
                        "body" => "Hi $order->customer_name, please open the following link to scan the qr code and confirm your order delivery. " . url('customer/delivery_confirmation/' . $order->customer_confirmation_code)
                    ]
                );
            } else if ($status=='on_route_pickup') {
                $order->status = $status;
                $timestamps->on_the_way_first = $current_timestamp;
            } else if ($status=='picked_up') {
                $order->status = $status;
                $timestamps->arrived_first = $current_timestamp;
            } else if ($status=='on_route') {
                $order->status = $status;
                $timestamps->on_the_way_second = $current_timestamp;
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
                'message' => 'Th order\'s status has been updated successfully',
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
                'message' => 'Th order\'s status has been updated successfully',
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
        $driver_id = \Auth::user()->id;
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

    public function getDriverRegistration(Request $request) {
        return view('doorder.drivers.registration');
    }
}
