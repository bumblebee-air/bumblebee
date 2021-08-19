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

    public function index(Request $request)
    {
        $user_role = auth()->user()->user_role;
        if ($user_role == 'retailer') {
            $admin_data = $this->retailerDashboardData();
            $drivers_arr = $admin_data['drivers_arr'];
            if ($request->has('accept_json')) {
                return $drivers_arr;
            }
            return view('admin.doorder.retailers.dashboard', compact('drivers_arr'));
        } else {
            $from_date = null;
            $to_date = null;
            $filter_from_date = $request->get('from_date');
            $filter_to_date = $request->get('to_date');
            $ajax_flag = false;
            if ($filter_from_date != null && $filter_to_date != null) {
                $ajax_flag = true;
                $filter_from_date = new Carbon($filter_from_date);
                $filter_to_date = new Carbon($filter_to_date);
                $from_date = $filter_from_date->startOfDay()->toDateTimeString();
                $to_date = $filter_to_date->endOfDay()->toDateTimeString();
            }
            $admin_data = $this->adminDashboardData($from_date, $to_date);
            $all_orders_count = $admin_data['all_orders_count'];
            $delivered_orders_count = $admin_data['delivered_orders_count'];
            $retailers_count = $admin_data['retailers_count'];
            $deliverers_count = $admin_data['deliverers_count'];
            $deliverers_order_charges = $admin_data['deliverers_order_charges'];
            $retailers_order_charges = $admin_data['retailers_order_charges'];
            $annual_chart_labels = $admin_data['annual_chart_labels'];
            $annual_chart_data = $admin_data['annual_chart_data'];
            $drivers_arr = $admin_data['drivers_arr'];
            if ($ajax_flag == true) {
                return response()->json($admin_data);
            }
            return view('admin.doorder.dashboard', compact('drivers_arr', 'all_orders_count', 'delivered_orders_count', 'retailers_count', 'deliverers_count', 'deliverers_order_charges', 'retailers_order_charges', 'annual_chart_labels', 'annual_chart_data'));
        }
    }

    public function getAdminMap()
    {
        $drivers = User::with('driver_profile')->where('user_role', '=', 'driver')->get();
        $drivers_arr = [];
        foreach ($drivers as $driver) {
            if ($driver->driver_profile != null && $driver->driver_profile->latest_coordinates != null) {
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver' => [
                        'name' => $driver->name
                    ],
                    'lat' => $lat,
                    'lon' => $lon,
                    'timestamp' => $coords_timestamp->toTimeString()
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return view('admin.doorder.drivers_map', compact('drivers_arr'));
    }

    private function retailerDashboardData()
    {
        $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->whereIn('status', [
            'on_route_pickup',
            'picked_up',
            'on_route'
        ])
            ->whereNotNull('driver')
            ->get();
        $drivers_arr = [];
        foreach ($orders as $order) {
            if ($order->orderDriver && $order->orderDriver->driver_profile != null && $order->orderDriver->driver_profile->latest_coordinates != null) {
                $coords = json_decode($order->orderDriver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($order->orderDriver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver' => [
                        'name' => $order->orderDriver->name,
                        'id' => $order->orderDriver->id
                    ],
                    'lat' => $lat,
                    'lon' => $lon,
                    'timestamp' => $coords_timestamp->format('H:i')
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return [
            'drivers_arr' => $drivers_arr
        ];
    }

    private function adminDashboardData($from_date, $to_date)
    {
        $custom_date = true;
        $current_date = Carbon::now();
        if ($from_date == null && $to_date == null) {
            $custom_date = false;
            $from_date = $current_date->startOfDay()->toDateTimeString();
            $to_date = $current_date->endOfDay()->toDateTimeString();
        }
        $all_orders = Order::query();
        $all_orders = $all_orders->whereBetween('created_at', [
            $from_date,
            $to_date
        ]);
        if (! $custom_date) {
            $all_orders = $all_orders->orWhere(function ($q) use ($from_date, $to_date) {
                $q->whereNotBetween('created_at', [
                    $from_date,
                    $to_date
                ])
                    ->whereNotIn('status', [
                    'delivered',
                    'cancelled'
                ]);
            });
        }
        $all_orders = $all_orders->get();

        $all_orders_count = count($all_orders);
        $delivered_orders_count = 0;

        $delivered_orders_count = Order::where('status', 'delivered')->whereHas('orderTimestamps', function ($q) use ($from_date, $to_date) {
            $q->where('model', 'order')
                ->whereBetween('completed', [
                $from_date,
                $to_date
            ]);
        })
            ->count();
        // foreach($all_orders as $order){
        // $order->orderTimestamps()->whereDate('')->where('model', 'order')->first();
        // if($order->status == 'delivered'){
        // $delivered_orders_count++;
        // }
        // }
        if ($custom_date == false) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfMonth()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfMonth()
                ->endOfDay()
                ->toDateTimeString();
        }
        $registered_retailers = Retailer::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $registered_deliverers = DriverProfile::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $retailers_count = count($registered_retailers);
        $deliverers_count = count($registered_deliverers);
        $month_period_orders = Order::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $retailers_orders = [];
        $deliverers_orders = [];
        foreach ($month_period_orders as $order) {
            if ($order->status == 'delivered' && $order->retailer_id != null) {
                if (isset($retailers_orders[$order->retailer_id])) {
                    $retailers_orders[$order->retailer_id] = $retailers_orders[$order->retailer_id] + 1;
                } else {
                    $retailers_orders[$order->retailer_id] = 1;
                }
            }
            if ($custom_date == true && $order->status == 'delivered' && $order->driver != null) {
                if (isset($deliverers_orders[$order->driver])) {
                    $deliverers_orders[$order->driver] = $deliverers_orders[$order->driver] + 1;
                } else {
                    $deliverers_orders[$order->driver] = 1;
                }
            }
        }
        $retailers_order_charges = [];
        foreach ($retailers_orders as $retailer_id => $order) {
            $retailer = Retailer::find($retailer_id);
            $retailer_name = $retailer->name;
            $order_charge = $order * 10;
            $order_count = (string) $order;
            $retailers_order_charges[] = (object) [
                'retailer_name' => $retailer_name,
                'order_count' => $order_count,
                'order_charge' => '€' . (string) $order_charge
            ];
        }
        if ($custom_date == false) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfWeek()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfWeek()
                ->endOfDay()
                ->toDateTimeString();
            $week_period_orders = Order::whereBetween('created_at', [
                $from_date,
                $to_date
            ])->get();
            foreach ($week_period_orders as $order) {
                if ($order->status == 'delivered' && $order->driver != null) {
                    if (isset($deliverers_orders[$order->driver])) {
                        $deliverers_orders[$order->driver] = $deliverers_orders[$order->driver] + 1;
                    } else {
                        $deliverers_orders[$order->driver] = 1;
                    }
                }
            }
        }
        $deliverers_order_charges = [];
        foreach ($deliverers_orders as $deliverer_id => $order) {
            $deliverer = User::find($deliverer_id);
            $deliverer_name = $deliverer->name;
            $order_charge = $order * 5;
            $order_count = (string) $order;
            $deliverers_order_charges[] = (object) [
                'deliverer_name' => $deliverer_name,
                'order_count' => $order_count,
                'order_charge' => '€' . (string) $order_charge
            ];
        }

        // Annual orders data
        // $current_date = Carbon::now()->subYear();
        $current_date = Carbon::now();
        $startOfYear = $current_date->startOfYear()->toDateTimeString();
        $endOfYear = $current_date->endOfYear()->toDateTimeString();
        $annual_orders = Order::whereBetween('created_at', [
            $startOfYear,
            $endOfYear
        ])->get();
        $annual_chart_labels = [];
        $annual_chart_data = [];
        for ($i = 0; $i < 12; $i ++) {
            $current_month = Carbon::parse($startOfYear)->addMonths($i);
            $start_of_month = $current_month->startOfMonth()->toDateTimeString();
            $end_of_month = $current_month->endOfMonth()->toDateTimeString();
            $month_orders = $annual_orders->whereBetween('created_at', [
                $start_of_month,
                $end_of_month
            ]);
            $annual_chart_labels[] = $current_month->format('M');
            $annual_chart_data[] = (string) count($month_orders);
        }
        $drivers = User::with('driver_profile')->where('user_role', '=', 'driver')->get();
        $drivers_arr = [];
        foreach ($drivers as $driver) {
            if ($driver->driver_profile != null && $driver->driver_profile->latest_coordinates != null) {
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver' => [
                        'name' => $driver->name,
                        'id' => $driver->id
                    ],
                    'lat' => $lat,
                    'lon' => $lon,
                    'timestamp' => $coords_timestamp->format('d M H:i')
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return [
            'drivers_arr' => $drivers_arr,
            'all_orders_count' => $all_orders_count,
            'delivered_orders_count' => $delivered_orders_count,
            'retailers_count' => $retailers_count,
            'deliverers_count' => $deliverers_count,
            'retailers_order_charges' => $retailers_order_charges,
            'deliverers_order_charges' => $deliverers_order_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data' => $annual_chart_data
        ];
    }

    public function metricsDashboard(Request $request)
    {
        $from_date = null;
        $to_date = null;
        $filter_from_date = $request->get('from_date');
        $filter_to_date = $request->get('to_date');
        $ajax_flag = false;
        if ($filter_from_date != null && $filter_to_date != null) {
            $ajax_flag = true;
            $filter_from_date = new Carbon($filter_from_date);
            $filter_to_date = new Carbon($filter_to_date);
            $from_date = $filter_from_date->startOfDay()->toDateTimeString();
            $to_date = $filter_to_date->endOfDay()->toDateTimeString();
        }
        $admin_data = $this->adminMetricsDashboardData($from_date, $to_date);
        $all_orders_count = $admin_data['all_orders_count'];
        $delivered_orders_count = $admin_data['delivered_orders_count'];
        $retailers_count = $admin_data['retailers_count'];
        $deliverers_count = $admin_data['deliverers_count'];
        $deliverers_order_charges = $admin_data['deliverers_order_charges'];
        $retailers_order_charges = $admin_data['retailers_order_charges'];
        $annual_chart_labels = $admin_data['annual_chart_labels'];
        $annual_chart_data_orders = $admin_data['annual_chart_data_orders'];
        $annual_chart_data_revenue = $admin_data['annual_chart_data_revenue'];
        $profit_loss_chart_labels = $admin_data['profit_loss_chart_labels'];
        $profit_loss_chart_data_profit = $admin_data['profit_loss_chart_data_profit'];
        $profit_loss_chart_data_loss = $admin_data['profit_loss_chart_data_loss'];

        $profitPercentage = $admin_data['profitPercentage'];
        $lossPercentage = $admin_data['lossPercentage'];
        $profit = $admin_data['profit'];
        $loss = $admin_data['loss'];
        $deliverersCharge = $admin_data['deliverersCharge'];
        $retailerCharge = $admin_data['retailerCharge'];

        
        if ($ajax_flag == true) {
            return response()->json($admin_data);
        }
        return view('admin.doorder.metrics_dashboard', compact('all_orders_count', 'delivered_orders_count', 'retailers_count', 'deliverers_count', 
            'deliverers_order_charges', 'retailers_order_charges', 'annual_chart_labels', 'annual_chart_data_orders', 'annual_chart_data_revenue', 
            'profitPercentage', 'lossPercentage', 'profit', 'loss', 'deliverersCharge', 'retailerCharge',
            'profit_loss_chart_labels','profit_loss_chart_data_profit','profit_loss_chart_data_loss'));
    }
    
    public function getMetricsChartLabelData(Request $request){
        $from_date = null;
        $to_date = null;
        $filter_from_date = $request->get('from_date');
        $filter_to_date = $request->get('to_date');
        
        $profit_loss_chart_labels = [];
        $profit_loss_chart_data = [];
        
        $label_name = $request->get('label_name');
        
        if ($filter_from_date != null && $filter_to_date != null) {
            $filter_from_date = new Carbon($filter_from_date);
            $filter_to_date = new Carbon($filter_to_date);
            $from_date = $filter_from_date->startOfDay()->toDateTimeString();
            $to_date = $filter_to_date->endOfDay()->toDateTimeString();
            
            if($label_name=='profitPercentage'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [10];
            }else if($label_name=='lossPercentage'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [8];
            }else if($label_name=='profitValue'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [30000];
                
            }else if($label_name=='lossValue'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [4500];
            }else if($label_name=='deliverersCharge'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [75000];
            }else if($label_name=='retailerCharge'){
                $profit_loss_chart_labels = ['Aug'];
                $profit_loss_chart_data = [800000];
            }
        }
        else{
            if($label_name=='profitPercentage'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [10,20];
            }else if($label_name=='lossPercentage'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [5,7];
            }else if($label_name=='profitValue'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [20000,10000];
                
            }else if($label_name=='lossValue'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [7000,8000];
            }else if($label_name=='deliverersCharge'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [100233,65000];
            }else if($label_name=='retailerCharge'){
                $profit_loss_chart_labels = ['Jul','Aug'];
                $profit_loss_chart_data = [500000,650000];
            }
        }
        
        
        return response()->json([
            'profit_loss_chart_labels'=>$profit_loss_chart_labels,
            'profit_loss_chart_data'=>$profit_loss_chart_data,
            
        ]);
    }
														
    private function adminMetricsDashboardData($from_date, $to_date)
    {
        $custom_date = true;
        $current_date = Carbon::now();
        if ($from_date == null && $to_date == null) {
            $custom_date = false;
            $from_date = $current_date->startOfDay()->toDateTimeString();
            $to_date = $current_date->endOfDay()->toDateTimeString();
        }
        $all_orders = Order::query();
        $all_orders = $all_orders->whereBetween('created_at', [
            $from_date,
            $to_date
        ]);
        if (! $custom_date) {
            $all_orders = $all_orders->orWhere(function ($q) use ($from_date, $to_date) {
                $q->whereNotBetween('created_at', [
                    $from_date,
                    $to_date
                ])
                    ->whereNotIn('status', [
                    'delivered',
                    'cancelled'
                ]);
            });
        }
        $all_orders = $all_orders->get();

        $all_orders_count = count($all_orders);
        $delivered_orders_count = 0;

        $delivered_orders_count = Order::where('status', 'delivered')->whereHas('orderTimestamps', function ($q) use ($from_date, $to_date) {
            $q->where('model', 'order')
                ->whereBetween('completed', [
                $from_date,
                $to_date
            ]);
        })
            ->count();
        // foreach($all_orders as $order){
        // $order->orderTimestamps()->whereDate('')->where('model', 'order')->first();
        // if($order->status == 'delivered'){
        // $delivered_orders_count++;
        // }
        // }
        if ($custom_date == false) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfMonth()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfMonth()
                ->endOfDay()
                ->toDateTimeString();
        }
        $registered_retailers = Retailer::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $registered_deliverers = DriverProfile::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $retailers_count = count($registered_retailers);
        $deliverers_count = count($registered_deliverers);
        $month_period_orders = Order::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $retailers_orders = [];
        $deliverers_orders = [];
        foreach ($month_period_orders as $order) {
            if ($order->status == 'delivered' && $order->retailer_id != null) {
                if (isset($retailers_orders[$order->retailer_id])) {
                    $retailers_orders[$order->retailer_id] = $retailers_orders[$order->retailer_id] + 1;
                } else {
                    $retailers_orders[$order->retailer_id] = 1;
                }
            }
            if ($custom_date == true && $order->status == 'delivered' && $order->driver != null) {
                if (isset($deliverers_orders[$order->driver])) {
                    $deliverers_orders[$order->driver] = $deliverers_orders[$order->driver] + 1;
                } else {
                    $deliverers_orders[$order->driver] = 1;
                }
            }
        }
        $retailers_order_charges = [];
        foreach ($retailers_orders as $retailer_id => $order) {
            $retailer = Retailer::find($retailer_id);
            $retailer_name = $retailer->name;
            $order_charge = $order * 10;
            $order_count = (string) $order;
            $retailers_order_charges[] = (object) [
                'retailer_name' => $retailer_name,
                'order_count' => $order_count,
                'order_charge' => '€' . (string) $order_charge
            ];
        }
        if ($custom_date == false) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfWeek()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfWeek()
                ->endOfDay()
                ->toDateTimeString();
            $week_period_orders = Order::whereBetween('created_at', [
                $from_date,
                $to_date
            ])->get();
            foreach ($week_period_orders as $order) {
                if ($order->status == 'delivered' && $order->driver != null) {
                    if (isset($deliverers_orders[$order->driver])) {
                        $deliverers_orders[$order->driver] = $deliverers_orders[$order->driver] + 1;
                    } else {
                        $deliverers_orders[$order->driver] = 1;
                    }
                }
            }
        }
        $deliverers_order_charges = [];
        foreach ($deliverers_orders as $deliverer_id => $order) {
            $deliverer = User::find($deliverer_id);
            $deliverer_name = $deliverer->name;
            $order_charge = $order * 5;
            $order_count = (string) $order;
            $deliverers_order_charges[] = (object) [
                'deliverer_name' => $deliverer_name,
                'order_count' => $order_count,
                'order_charge' => '€' . (string) $order_charge
            ];
        }

        // Annual orders data
        // $current_date = Carbon::now()->subYear();
        $current_date = Carbon::now();
        $startOfYear = $current_date->startOfYear()->toDateTimeString();
        $endOfYear = $current_date->endOfYear()->toDateTimeString();
        $annual_orders = Order::whereBetween('created_at', [
            $startOfYear,
            $endOfYear
        ])->get();
        $annual_chart_labels = [];
        $annual_chart_data_orders = [];
        for ($i = 0; $i < 12; $i ++) {
            $current_month = Carbon::parse($startOfYear)->addMonths($i);
            $start_of_month = $current_month->startOfMonth()->toDateTimeString();
            $end_of_month = $current_month->endOfMonth()->toDateTimeString();
            $month_orders = $annual_orders->whereBetween('created_at', [
                $start_of_month,
                $end_of_month
            ]);
            $annual_chart_labels[] = $current_month->format('M');
            $annual_chart_data_orders[] = (string) count($month_orders);
        }
        $annual_chart_data_revenue = [
            2,
            5,
            3,
            4,
            8,
            4,
            2,
            3,
            1,
            0,
            0,
            0
        ];
        
        $profit_loss_chart_labels = ['Jul','Aug'];
        $profit_loss_chart_data_profit = [10000,5000];
        $profit_loss_chart_data_loss = [5000,2000];

        $profitPercentage = '+60%';
        $lossPercentage = '0%';
        $profit = '€650';
        $loss = '€29,000';
        $deliverersCharge = '€233,600';
        $retailerCharge = '€2,480,00';

        return [
            'all_orders_count' => $all_orders_count,
            'delivered_orders_count' => $delivered_orders_count,
            'retailers_count' => $retailers_count,
            'deliverers_count' => $deliverers_count,
            'retailers_order_charges' => $retailers_order_charges,
            'deliverers_order_charges' => $deliverers_order_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data_orders' => $annual_chart_data_orders,
            'annual_chart_data_revenue' => $annual_chart_data_revenue,
            'profitPercentage' => $profitPercentage,
            'lossPercentage' => $lossPercentage,
            'profit' => $profit,
            'loss' => $loss,
            'deliverersCharge' => $deliverersCharge,
            'retailerCharge' => $retailerCharge,
            'profit_loss_chart_labels'=>$profit_loss_chart_labels,
            'profit_loss_chart_data_profit'=>$profit_loss_chart_data_profit,
            'profit_loss_chart_data_loss'=>$profit_loss_chart_data_loss
        ];
    }
}
