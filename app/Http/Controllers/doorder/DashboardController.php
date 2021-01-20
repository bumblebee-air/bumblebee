<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Order;
use App\Retailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user_role = auth()->user()->user_role;
        if($user_role == 'retailer'){
            $admin_data = $this->retailerDashboardData();
            $drivers_arr = $admin_data['drivers_arr'];
            if ($request->has('accept_json')) {
                return $drivers_arr;
            }
            return view('admin.doorder.retailers.dashboard',compact('drivers_arr'));
        } else {
            $from_date = null;
            $to_date = null;
            $filter_from_date = $request->get('from_date');
            $filter_to_date = $request->get('to_date');
            if($filter_from_date!=null && $filter_to_date!=null){
                $filter_from_date = new Carbon($filter_from_date);
                $filter_to_date = new Carbon($filter_to_date);
                $from_date = $filter_from_date->startOfDay()->toDateTimeString();
                $to_date = $filter_to_date->endOfDay()->toDateTimeString();
            }
            $admin_data = $this->adminDashboardData($from_date,$to_date);
            $all_orders_count = $admin_data['all_orders_count'];
            $delivered_orders_count = $admin_data['delivered_orders_count'];
            $retailers_count = $admin_data['retailers_count'];
            $deliverers_count = $admin_data['deliverers_count'];
            $drivers_arr = $admin_data['drivers_arr'];
            return view('admin.doorder.dashboard',compact('drivers_arr'));
        }
    }

    public function getAdminMap(){
        $drivers = User::with('driver_profile')->where('user_role','=','driver')->get();
        $drivers_arr = [];
        foreach($drivers as $driver){
            if($driver->driver_profile!=null && $driver->driver_profile->latest_coordinates!=null){
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver'=>[
                        'name'=>$driver->name
                    ],
                    'lat'=>$lat,
                    'lon'=>$lon,
                    'timestamp'=>$coords_timestamp->toTimeString()
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return view('admin.doorder.drivers_map',compact('drivers_arr'));
    }

    private function retailerDashboardData(){
        $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->
            whereIn('status', ['on_route_pickup','picked_up', 'on_route'])->
            whereNotNull('driver')->get();
        $drivers_arr = [];
        foreach($orders as $order){
            if($order->orderDriver && $order->orderDriver->driver_profile!=null && $order->orderDriver->driver_profile->latest_coordinates!=null){
                $coords = json_decode($order->orderDriver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($order->orderDriver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver'=>[
                        'name'=>$order->orderDriver->name,
                        'id'=>$order->orderDriver->id
                    ],
                    'lat'=>$lat,
                    'lon'=>$lon,
                    'timestamp'=>$coords_timestamp->format('H:i')
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return ['drivers_arr'=>$drivers_arr];
    }

    private function adminDashboardData($from_date,$to_date){
        $custom_date = true;
        $current_date = Carbon::now();
        if($from_date==null && $to_date==null) {
            $custom_date = false;
            $from_date = $current_date->startOfDay()->toDateTimeString();
            $to_date = $current_date->endOfDay()->toDateTimeString();
        }
        $all_orders = Order::whereBetween('created_at',[$from_date,$to_date])->get();
        $all_orders_count = count($all_orders);
        $delivered_orders_count = 0;
        foreach($all_orders as $order){
            if($order->status == 'delivered'){
                $delivered_orders_count++;
            }
        }
        if($custom_date == false) {
            $from_date = $current_date->startOfMonth()->startOfDay()->toDateTimeString();
            $to_date = $current_date->endOfMonth()->endOfDay()->toDateTimeString();
        }
        $registered_retailers = Retailer::whereBetween('created_at',[$from_date,$to_date])->get();
        $registered_deliverers = DriverProfile::whereBetween('created_at',[$from_date,$to_date])->get();
        $retailers_count = count($registered_retailers);
        $deliverers_count = count($registered_deliverers);
        $drivers = User::with('driver_profile')->where('user_role','=','driver')->get();
        $drivers_arr = [];
        foreach($drivers as $driver){
            if($driver->driver_profile!=null && $driver->driver_profile->latest_coordinates!=null){
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver'=>[
                        'name'=>$driver->name,
                        'id'=>$driver->id
                    ],
                    'lat'=>$lat,
                    'lon'=>$lon,
                    'timestamp'=>$coords_timestamp->format('H:i')
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return ['drivers_arr'=>$drivers_arr, 'all_orders_count'=>$all_orders_count,
            'delivered_orders_count'=>$delivered_orders_count, 'retailers_count'=>$retailers_count,
            'deliverers_count'=>$deliverers_count];
    }
}
