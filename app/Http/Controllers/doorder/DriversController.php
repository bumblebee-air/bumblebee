<?php

namespace App\Http\Controllers\doorder;

use App\Helpers\SecurityHelper;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
            if($status=='delivered'){
                $order->status = 'delivered';
            }
            $order->save();
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
        } else {
            if($status=='accepted'){
                if($order->driver!=null){
                    $response = [
                        'message' => 'This order has already been accepted by another driver',
                        'error' => 1
                    ];
                    return response()->json($response)->setStatusCode(403);
                }
                $order->status = 'matched';
                $order->driver = $driver_id;
                $order->driver_status = $status;
            }elseif($status=='rejected'){
                if($order->driver != (string)$driver_id){
                    $response = [
                        'message' => 'This order does not belong to this driver',
                        'error' => 1
                    ];
                    return response()->json($response)->setStatusCode(403);
                }
                $order->status = 'pending';
                $order->driver = null;
                $order->driver_status = null;
            }
            $order->save();
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
        $order = json_decode(json_encode($order),true);
        $response = [
            'order' => $order,
            'message' => 'Order retrieved successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
