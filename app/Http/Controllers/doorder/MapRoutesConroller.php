<?php

namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\DriverProfile;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\Order;
use App\Retailer;
use App\UserFirebaseToken;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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
                $driver_coordinates_lat = null;
                $driver_coordinates_lon = null;
                $driver_latest_coordinates = ($item->latest_coordinates != null) ? json_decode($item->latest_coordinates) : null;
                if ($driver_latest_coordinates == null) {
                    if ($item->address_coordinates != null) {
                        $driver_latest_coordinates = json_decode($item->address_coordinates);
                        $driver_coordinates_lat = $driver_latest_coordinates->lat;
                        $driver_coordinates_lon = $driver_latest_coordinates->lon;
                    }
                } else {
                    $driver_coordinates_lat = $driver_latest_coordinates->lat;
                    $driver_coordinates_lon = $driver_latest_coordinates->lng;
                }
                $coordinates_error = ($driver_latest_coordinates != null) ? 0 : 1;
                //                 dd($coordinates_error);
                //                 if($coordinates_error) {return $item->id;}
                return [
                    'deliverer_id' => (string)$item->id,
                    'deliverer_coordinates' => $driver_coordinates_lat . ',' . $driver_coordinates_lon,
                    'coordinates_error' => $coordinates_error
                ];
            });
            $orders_address = $orders->map(function ($item) {
                return [
                    'order_id' => (string)$item->id,
                    'pickup' => $item->pickup_lat . ',' . $item->pickup_lon,
                    'dropoff' => $item->customer_address_lat . ',' . $item->customer_address_lon,
                ];
            });
            $deliverers_coordinates_enc = json_encode($deliverers_coordinates);
            $orders_address_enc = json_encode($orders_address);
            \Log::info('Multi-driver route optimize request for driver with coordinates: ' . $deliverers_coordinates_enc .
                '. Orders data: ' . $orders_address_enc);
            $route_opt_url = env('ROUTE_OPTIMIZE_URL', 'https://afternoon-lake-03061.herokuapp.com') . '/routing_table';
            $route_request = Http::post($route_opt_url, [
                'deliverers_coordinates' => $deliverers_coordinates_enc,
                'orders_address' => $orders_address_enc
            ]);

            $response = $route_request->getBody();
            \Log::info('Multi-driver route optimize request succeeded with data: ' . $response);
            $response = json_decode($response);
            //  dd($response);
            $response = collect($response)->map(function ($item) {
                //Add driver's name initials to the route
                $driver = DriverProfile::find($item[0]->deliverer_id);
                $item[0]->deliverer_name = $driver->user->name;
                $letters = strtoupper($driver->first_name[0]) . strtoupper($driver->last_name[0]);
                // $words = preg_split("/\s+/", $driver->user->name);
                // foreach ($words as $w) {
                //  $letters .= strtoupper($w[0]);
                // }
                $item[0]->deliverer_first_letter = $letters;

                return $item;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        try {
            //Add ETAs to the orders
            foreach ($response as $driver_route) {
                $cumulative_eta = Carbon::now();
                foreach ($driver_route as $key => $route_point) {
                    //skip driver's point
                    if ($key == 0) continue;
                    $order_id = $route_point->order_id;
                    $the_eta = $route_point->ETA;
                    $cumulative_eta->addMinutes(intval($the_eta));
                    $the_order = Order::find($order_id);
                    if ($the_order) {
                        $the_order->the_eta = $cumulative_eta->toTimeString();
                        $the_order->save();
                    }
                }
            }
        } catch (\Exception $exception){
            \Log::error('Extracting ETA from optimized route failed with reason: '.
                $exception->getMessage());
        }
        Session::put('selectedDrivers', $request->selectedDrivers);
        Session::put("selectedOrders", explode(',', $request->selectedOrders));
        Session::put('mapRoutes', $response);

        return response()->json(array(
            "msg" => "Done",
            "selectedOrders" => explode(',', $request->selectedOrders),
            "selectedDrivers" => $request->selectedDrivers,
            "mapRoutes" => json_encode($response)
        ));
    }

    public function getMapRoutes(Request $request)
    {
        // dd(Session::get('selectedOrders'));
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();

        return view('admin.doorder.map_routes', [
            'available_drivers' => $accepted_deliverers,
            'map_routes' => Session::get('mapRoutes'),
            "selectedOrders" => Session::get('selectedOrders'),
            "selectedDrivers" => Session::get('selectedDrivers')
        ]);
    }

    public function SendOrdersToDrivers(Request $request)
    {
        try {
            // $map_routes = Session::get('mapRoutes');
            $map_routes = $request->mapRoutes;
            foreach ($map_routes as $route) {
                // dd($route);
                $driver = DriverProfile::find($route[0]["deliverer_id"]);
                if (empty($driver)) {
                    throw new \Exception("Driver Not Found !", 400);
                }
                $orders = array_filter($route, function ($item) {
                    return isset($item["type"]) &&  $item["type"] == 'pickup';
                });
                foreach ($orders as $key => $order) {
                    $order = Order::find($order["order_id"]);
                    $order->driver = $driver->user_id;
                    $order->status = 'assigned';
                    $order->driver_status = 'assigned';
                    $order->save();
                    $this->SendNotification($order["order_id"], $driver->user);
                }
            }
            // alert()->success("The orders has been successfully assigned to the drivers");
            // return redirect()->to('doorder/orders');
            return response()->json(array(
                "msg" => "Done",
                "message" => "The orders has been successfully assigned to the drivers"
            ));
        } catch (\Throwable $th) {
            // alert()->error($th->getMessage());
            // return back();
            return response()->json(array(
                "msg" => "Fail",
                "message" => $th->getMessage()
            ));
        }
    }

    private function SendNotification($order_id, $user)
    {
        $notification_message = "Order #$order_id has been assigned to you";
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

    public function getOrdersRouteOptimization(Request $request)
    {
        //
        if (auth()->user()->user_role == 'retailer') {
            $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->where('is_archived', false)
                ->where('status', '!=', 'delivered')->whereNotIn('id', Session::get('selectedOrders'));
        } else {
            $orders = Order::where('is_archived', false)->where('status', '!=', 'delivered')->where('driver', null)->whereNotIn('id', Session::get('selectedOrders'));
        }
        if (session()->get('country') !== null) {
            $orders = $orders->where(function ($q) {
                $q->where('pickup_address', 'like', '%' . session()->get('country') . '%')->orWhere('customer_address', 'like', '%' . session()->get('country') . '%');
            });
        }
        if (session()->get('city') !== null) {
            $orders = $orders->where(function ($q) {
                $q->where('pickup_address', 'like', '%' . session()->get('city') . '%')->orWhere('customer_address', 'like', '%' . session()->get('city') . '%');
            });
        }
        $orders = $orders->orderBy('id', 'desc')->get();

        // $events=[];
        // foreach ($orders as $order){
        // $events[] = [
        // 'id' => $order->id,
        // 'start' => $order->created_at,
        // 'className' => 'orderStatusCalendar '. $order->status .'Status',
        // 'title' => $order->retailer_name,
        // 'status'=> $order->status,
        // 'retailer_id'=>$order->retailer_id
        // ];
        // }

        foreach ($orders as $order) {
            $order->time = $order->created_at->format('d M y H:i A');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
            $order->fulfilment_date = $order->fulfilment_date ? Carbon::createFromFormat('Y-m-d H:i:s', $order->fulfilment_date)->format('d-m-Y H:i A') : Null;
        }

        // return $orders;
        return response()->json(array(
            "msg" => "Done",
            "orders" => $orders
        ));
    }

    public function getOrderDataRouteOptimization(Request $request)
    {
        $id = $request->order_id;

        $order = Order::find($id);

        if (!$order) {
            alert()->error('No order was found!');
            return redirect()->back();
        }
        $customer_name = explode(' ', $order->customer_name);
        $first_name = $customer_name[0];
        $last_name = $customer_name[1] ?? '';
        $order->first_name = $first_name;
        $order->last_name = $last_name;

        return response()->json(array(
            "msg" => "Done",
            "order" => $order
        ));
    }
}
