<?php

namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\DriverProfile;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\Order;
use App\UserFirebaseToken;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class MapRoutesConroller extends Controller
{

    public function index()
    {
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();

        $route1 = array(
            array(
                "deliverer_id" => 2,
                "coordinates" => "53.40264481,-6.4309825"
            ),
            array(
                "coordinates" => "53.4264481,-6.243099098",
                "order_id" => "14",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.42604481,-6.12499098",
                "order_id" => "13",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.29034,-6.17659",
                "order_id" => "15",
                "type" => "pickup"
            ),

            array(
                "coordinates" => "53.289851,-6.24756",
                "order_id" => "14",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.304581,-6.205543",
                "order_id" => "13",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.34581, -6.25543",
                "order_id" => "15",
                "type" => "dropoff"
            )
        );
        $route2 = array(
            array(
                "deliverer_id" => 3,
                "coordinates" => "53.34581,-6.5285543"
            ),
            array(
                "coordinates" => "53.334981, -6.526025",
                "order_id" => "24",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.32604,-6.531861",
                "order_id" => "23",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.234868,-6.539165",
                "order_id" => "24",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.2034868,-6.5020463",
                "order_id" => "23",
                "type" => "dropoff"
            )
        );
        $routes = array(
            $route1,
            $route2
        );

        return view('admin.doorder.map_routes', [
            'drivers' => $accepted_deliverers,

            'map_routes' => json_encode($routes)
        ]);
    }

    public function getRouteOfDriver(Request $request)
    {
        // dd($request);
        $route = array(
            array(
                "coordinates" => "53.31682848327396,-6.24794205957005"
            ),
            array(
                "coordinates" => "53.31966803641148,-6.2487762491371335",
                "order_id" => "24",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.321359944283834,-6.248003772940844",
                "order_id" => "25",
                "type" => "pickup"
            ),

            array(
                "coordinates" => "53.31807860730656,-6.247059635367602",
                "order_id" => "24",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.31741205490382,-6.247660450186938",
                "order_id" => "25",
                "type" => "dropoff"
            )
        );

        return response()->json(array(
            "msg" => "test test",
            "driverId" => $request->driverId,
            "route" => $route
        ));
    }

    public function assignDriverEnableRouteOptimization(Request $request)
    {
        try {
            $deliverers = DriverProfile::whereIn('id', $request->selectedDrivers)->get();
            $orders = Order::whereIn('id', explode(',', $request->selectedOrders))->get();
            $deliverers_coordinates = $deliverers->map(function ($item) {
                return [
                    'deliverer_id' => $item->id,
                    'deliverer_coordinates' => json_decode($item->address_coordinates)->lat . ',' . json_decode($item->address_coordinates)->lon,
                ];
            });
            $orders_address = $orders->map(function ($item) {
                return [
                    'order_id' => $item->id,
                    'pickup' => $item->pickup_lat . ',' . $item->pickup_lon,
                    'dropoff' => $item->customer_address_lat . ',' . $item->customer_address_lon,
                ];
            });

            $route_request = Http::post('https://peaceful-ridge-07017.herokuapp.com/routing_table', [
                'deliverers_coordinates' => json_encode($deliverers_coordinates),
                'orders_address' => json_encode($orders_address)
            ]);


            $response = $route_request->getBody();
            $response = json_decode($response);
            $response = collect($response)->map(function ($item) {
                $driver = DriverProfile::find($item[0]->deliverer_id);
                $item[0]->deliverer_name = $driver->user->name;
                $words = preg_split("/\s+/", $driver->user->name);
                $letters = '';
                foreach ($words as $w) {
                    $letters .= strtoupper($w[0]);
                }
                $item[0]->deliverer_first_letter = $letters;
                return $item;
            });
            Session::put('selectedDrivers', $request->selectedDrivers);
            Session::put('mapRoutes', $response);

            return response()->json(array(
                "msg" => "Done",
                "selectedOrders" => $request->selectedOrders,
                "selectedDrivers" => $request->selectedDrivers,
                "mapRoutes" => json_encode($response)
            ));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getMapRoutes(Request $request)
    {
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();
        return view('admin.doorder.map_routes', [
            'drivers' => $accepted_deliverers,
            'map_routes' => Session::get('mapRoutes'),
            "selectedOrders" => Session::get('selectedOrders'),
            "selectedDrivers" => Session::get('selectedDrivers'),
        ]);
    }

    public function SendOrdersToDrivers(Request $request)
    {
        try {
            $map_routes = Session::get('mapRoutes');
            foreach ($map_routes as $route) {
                $driver = DriverProfile::find($route[0]->deliverer_id);
                if (empty($driver)) {
                    throw new \Exception("Driver Not Found !", 400);
                }
                $orders = array_filter($route, function ($item) {
                    return isset($item->type) &&  $item->type == 'pickup';
                });
                foreach ($orders as $key => $order) {
                    $order = Order::find($order->order_id);
                    $order->driver = $driver->user_id;
                    $order->status = 'assigned';
                    $order->driver_status = 'assigned';
                    $order->save();
                    $this->SendNotification($order->order_id, $driver->user);
                }
            }
            alert()->success("The orders has been successfully assigned to the drivers");
            return redirect()->to('doorder/orders');
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    private function SendNotification($order_id, $user)
    {
        $notification_message = "Order #$order_id) has been assigned to you";
        $sms_message = "Hi $user->name, there is an order assigned to you, please open your app. " .
            url('driver_app#/order-details/' . $order_id);
        //Send Assignment Notification
        $user_tokens = UserFirebaseToken::where('user_id', $user->id)->get()->pluck('token')->toArray();
        if (!empty($user_tokens)) {
            self::sendFCM($user_tokens, [
                'title' => 'Order assigned',
                'message' => $notification_message,
                'order_id' => $order_id
            ]);
        }
        //SMS Assignment Notificatio
        TwilioHelper::sendSMS('DoOrder', $user->phone, $sms_message);
    }
}
