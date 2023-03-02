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
        if ($user_role == 'driver_manager') {
            return redirect()->to('doorder/orders');
        } elseif ($user_role == 'investor') {
            return redirect()->to('doorder/metrics_dashboard');
        } elseif ($user_role == 'retailer') {
            $admin_data = $this->retailerDashboardData();
            $drivers_arr = $admin_data['drivers_arr'];
            if ($request->has('accept_json')) {
                return $drivers_arr;
            }
            return view('admin.doorder.retailers.dashboard', compact('drivers_arr'));
        } else {
            $ajax_flag = $request->get('from_date') ? true : false;
            $default  = $request->get('from_date') ? false : true;
            $from_date = $request->get('from_date') ? new Carbon($request->get('from_date')) : Carbon::now()->startOfDay()->toDateTimeString();
            $to_date = $request->get('to_date') ? new Carbon($request->get('to_date')) : Carbon::now()->endOfDay()->toDateTimeString();
            $admin_data = $this->adminDashboardData($from_date, $to_date, $default);
            $all_orders_count = $admin_data['all_orders_count'];
            $delivered_orders_count = $admin_data['delivered_orders_count'];
            $retailers_count = $admin_data['retailers_count'];
            $deliverers_count = $admin_data['deliverers_count'];
            $deliverers_order_charges = $admin_data['deliverers_order_charges'];
            $retailers_order_charges = $admin_data['retailers_order_charges'];
            $annual_chart_labels = $admin_data['annual_chart_labels'];
            $annual_chart_data = $admin_data['annual_chart_data'];
            $annual_chart_data_last = $admin_data['annual_chart_data_last'];
            $drivers_arr = $admin_data['drivers_arr'];

            $thisWeekPercentage = round($admin_data['thisWeekPercentage'], 2);
            $lastWeekPercentage = round($admin_data['lastWeekPercentage'], 2);
            $thisMonthPercentage = round($admin_data['thisMonthPercentage'], 2);
            $lastMonthPercentage = round($admin_data['lastMonthPercentage'], 2);

            // $week_chart_labels = $admin_data['week_chart_labels'];
            // $last_week_chart_values = $admin_data['last_week_chart_values'];
            // $this_week_chart_values = $admin_data['this_week_chart_values'];

            $pickup_arr = $admin_data['pickup_arr'];
            $dropoff_arr = $admin_data['dropoff_arr'];

            if ($ajax_flag == true) {
                return response()->json($admin_data);
            }
            return view('admin.doorder.dashboard', compact('drivers_arr', 'all_orders_count', 'delivered_orders_count', 'retailers_count', 'deliverers_count', 'deliverers_order_charges', 'retailers_order_charges', 'thisWeekPercentage', 'lastWeekPercentage', 'thisMonthPercentage', 'lastMonthPercentage', 'annual_chart_labels', 'annual_chart_data', 'annual_chart_data_last', 'pickup_arr', 'dropoff_arr'));
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

    public function searchOrderMap(Request $request)
    {
        $search_val = $request->search_val;

        $driver_pin = [
            'driver' => [
                'name' => 'sara reda',
                'id' => 2
            ],
            'lat' => 53.34981,
            'lon' => -6.26031
        ];
        $pickup_pin = [
            'pickup_address' => 'St James\'s Hospital, James Street, Saint James\' (part of Phoenix Park), Dublin 8, Ireland',
            'pickup_lat' => 53.3393,
            'pickup_lon' => -6.29651,
            'retailer_name' => "sara yassen",
            'order_id' => 28884
        ];
        $dropoff_pin = [
            'customer_address' => "Phoenix Park, Dublin 8, Ireland",
            'customer_address_lat' => 53.35588,
            'customer_address_lon' => -6.32981,
            'customer_name' => 'mohamed fayez',
            'order_id' => 28884
        ];

        return response()->json([
            'driver_pin' => $driver_pin,
            'dropoff_pin' => $dropoff_pin,
            'pickup_pin' => $pickup_pin
        ]);
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

    private function adminDashboardData($from_date, $to_date, $default = false)
    {
        $all_orders = Order::query();
        $all_orders = $all_orders->whereBetween('created_at', [$from_date, $to_date]);
        $all_orders = $all_orders->get();

        $all_orders_count = count($all_orders);
        $delivered_orders_count = 0;

        $delivered_orders_count = Order::where('status', 'delivered')->whereHas('orderTimestamps', function ($q) use ($from_date, $to_date) {
            $q->where('model', 'order')->whereBetween('completed', [$from_date, $to_date]);
        })->count();
        if ($default) {
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
            if ($default == true && $order->status == 'delivered' && $order->driver != null) {
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
        if ($default) {
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
        $annual_chart_data_last = [];
        for ($i = 0; $i < 12; $i++) {
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

        // Week & Month percentages
        /*$thisWeekPercentage = -20;
        $lastWeekPercentage = 18;
        $thisMonthPercentage = 25;
        $lastMonthPercentage = 15;*/
        $thisWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->startOfWeek()->toDateTimeString(), Carbon::now()->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count();
        $lastWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek()->toDateTimeString(), Carbon::now()->subWeek()->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $lastlastWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->subWeeks(2)->startOfWeek()->toDateTimeString(), Carbon::now()->subWeeks(2)->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $thisWeekPercentage = (($thisWeekPercentage - $lastWeekPercentage) / $lastWeekPercentage) * 100;
        $lastWeekPercentage = (($lastWeekPercentage - $lastlastWeekPercentage) / $lastlastWeekPercentage) * 100;

        $thisMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count();
        $lastMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $lastlastMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString(), Carbon::now()->subMonths(2)->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $thisMonthPercentage = (($thisMonthPercentage - $lastMonthPercentage) / $lastMonthPercentage) * 100;
        $lastMonthPercentage = (($lastMonthPercentage - $lastlastMonthPercentage) / $lastlastMonthPercentage) * 100;

        // $week_chart_labels = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        // $last_week_chart_values = array(10,12,8,11,20,5,6);
        // $this_week_chart_values = array(12,15,10,10,14,6,7);

        //Pickup & Dropoff points for map pins
        $pickup_arr = [];
        $dropoff_arr = [];
        //Get only non completed orders
        $orders = Order::where('is_archived', false)
            ->where('status', '!=', 'delivered')->get();
        foreach ($orders as $order) {
            $pickup_arr[] = [
                'pickup_address' => preg_replace('/[^A-Za-z0-9\-]/', ' ',$order->pickup_address),
                'pickup_lat' => $order->pickup_lat,
                'pickup_lon' => $order->pickup_lon,
                'retailer_name' => $order->retailer_name,
                'order_id' => $order->order_id
            ];
            $dropoff_arr[] = [
                'customer_address' => preg_replace('/[^A-Za-z0-9\-]/',' ',$order->customer_address),
                'customer_address_lat' => $order->customer_address_lat,
                'customer_address_lon' => $order->customer_address_lon,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'order_id' => $order->order_id
            ];
        }
        $pickup_arr = json_encode($pickup_arr, JSON_HEX_APOS);
        $dropoff_arr = json_encode($dropoff_arr, JSON_HEX_APOS);

        return [
            'drivers_arr' => $drivers_arr,
            'all_orders_count' => $all_orders_count,
            'delivered_orders_count' => $delivered_orders_count,
            'retailers_count' => $retailers_count,
            'deliverers_count' => $deliverers_count,
            'retailers_order_charges' => $retailers_order_charges,
            'deliverers_order_charges' => $deliverers_order_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data' => $annual_chart_data,
            'annual_chart_data_last' => $annual_chart_data_last,
            'thisWeekPercentage' => $thisWeekPercentage,
            'lastWeekPercentage' => $lastWeekPercentage,
            'thisMonthPercentage' => $thisMonthPercentage,
            'lastMonthPercentage' => $lastMonthPercentage,
            'pickup_arr' => $pickup_arr,
            'dropoff_arr' => $dropoff_arr
        ];
    }

    public function metricsDashboard(Request $request)
    {
        $ajax_flag = $request->get('from_date') ? true : false;
        $default  = $request->get('from_date') ? false : true;
        $from_date = $request->get('from_date') ? new Carbon($request->get('from_date')) : Carbon::now()->startOfDay()->toDateTimeString();
        $to_date = $request->get('to_date') ? new Carbon($request->get('to_date')) : Carbon::now()->endOfDay()->toDateTimeString();
        $admin_data = $this->adminMetricsDashboardData($from_date, $to_date, $default);
        $all_orders_count = $admin_data['all_orders_count'];
        $delivered_orders_count = $admin_data['delivered_orders_count'];
        $retailers_count = $admin_data['retailers_count'];
        $deliverers_count = $admin_data['deliverers_count'];
        $deliverers_order_charges = $admin_data['deliverers_order_charges'];
        $retailers_order_charges = $admin_data['retailers_order_charges'];
        $annual_chart_labels = $admin_data['annual_chart_labels'];
        $annual_chart_data_orders = $admin_data['annual_chart_data_orders'];
        $annual_chart_data_orders_last = $admin_data['annual_chart_data_orders_last'];

        // $annual_chart_data_revenue = $admin_data['annual_chart_data_revenue'];
        $profit_loss_chart_labels = $admin_data['profit_loss_chart_labels'];
        $profit_loss_chart_data_profit = $admin_data['profit_loss_chart_data_profit'];
        $profit_loss_chart_data_loss = $admin_data['profit_loss_chart_data_loss'];

        $profitPercentage = $admin_data['profitPercentage'];
        $lossPercentage = $admin_data['lossPercentage'];
        $profit = $admin_data['profit'];
        $loss = $admin_data['loss'];
        $deliverersCharge = $admin_data['deliverersCharge'];
        $retailerCharge = $admin_data['retailerCharge'];
        $deliverersRevenuePercentage = $admin_data['deliverersRevenuePercentage'];
        $retailersRevenuePercentage = $admin_data['retailersRevenuePercentage'];

        $thisWeekPercentage = round($admin_data['thisWeekPercentage'],2);
        $lastWeekPercentage = round($admin_data['lastWeekPercentage'],2);
        $thisMonthPercentage =round( $admin_data['thisMonthPercentage'],2);
        $lastMonthPercentage = round($admin_data['lastMonthPercentage'],2);

        $thisMonthAverage =  round($admin_data['thisMonthAverage'],2);
        $lastMonthAverage =  round($admin_data['lastMonthAverage'],2);

        // $week_chart_labels = $admin_data['week_chart_labels'];
        // $last_week_chart_values = $admin_data['last_week_chart_values'];
        // $this_week_chart_values = $admin_data['this_week_chart_values'];

        $average_chart_labels = $admin_data['average_chart_labels'];
        $this_month_average_chart_values = $admin_data['this_month_average_chart_values'];
        $last_month_average_chart_values = $admin_data['last_month_average_chart_values'];

        if ($ajax_flag == true) {
            return response()->json($admin_data);
        }
        return view('admin.doorder.metrics_dashboard', compact('all_orders_count', 'delivered_orders_count', 'retailers_count', 'deliverers_count', 'deliverers_order_charges', 'retailers_order_charges', 'annual_chart_labels', 'annual_chart_data_orders', 'annual_chart_data_orders_last', 'profitPercentage', 'lossPercentage', 'profit', 'loss', 'deliverersCharge', 'retailerCharge', 'profit_loss_chart_labels', 'profit_loss_chart_data_profit', 'profit_loss_chart_data_loss', 'deliverersRevenuePercentage', 'retailersRevenuePercentage', 'thisWeekPercentage', 'lastWeekPercentage', 'thisMonthPercentage', 'lastMonthPercentage', 'thisMonthAverage', 'lastMonthAverage', 'average_chart_labels', 'this_month_average_chart_values', 'last_month_average_chart_values'));
    }

    public function getMetricsChartLabelData(Request $request)
    {
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

            if ($label_name == 'profitPercentage') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    10
                ];
            } else if ($label_name == 'lossPercentage') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    8
                ];
            } else if ($label_name == 'profitValue') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    30000
                ];
            } else if ($label_name == 'lossValue') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    4500
                ];
            } else if ($label_name == 'deliverersCharge') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    75000
                ];
            } else if ($label_name == 'retailerCharge') {
                $profit_loss_chart_labels = [
                    'Aug'
                ];
                $profit_loss_chart_data = [
                    800000
                ];
            }
        } else {
            $profit_loss_chart_labels = [];
            $profit_loss_chart_data_profit = [];
            $profit_loss_chart_data_loss = [];
            $profit = 0;
            $loss = 0;
            $deliverersCharge = 0;
            $retailerCharge = 0;
            $deliverers_revenue = [];
            $retailers_revenue = [];
            for ($i = 2; $i > 0; $i--) {
                $the_month = Carbon::now()->subMonths($i);
                $profit_loss_chart_labels[] = $the_month->shortMonthName;
                $start_of_month = $the_month->startOfMonth()->toDateTimeString();
                $end_of_month = $the_month->endOfMonth()->toDateTimeString();
                $the_month_orders = Order::whereBetween('created_at', [
                    $start_of_month,
                    $end_of_month
                ])->get();
                $the_month_revenue = count($the_month_orders) * 10;
                $the_month_profit = $the_month_revenue / 2;
                $the_month_loss = $the_month_revenue / 2;
                $profit_loss_chart_data_profit[] = $the_month_profit;
                $profit_loss_chart_data_loss[] = 0; // $the_month_loss;//0 temporarily
                $profit += $the_month_profit;
                $loss += 0; // $the_month_loss;//0 temporarily
                $deliverersCharge += $the_month_loss;
                $retailerCharge += $the_month_revenue;
                $deliverers_revenue[] = $the_month_loss;
                $retailers_revenue[] = $the_month_revenue;
            }
            if ($label_name == 'profitPercentage') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [10,20];
                $profit_loss_chart_data = $profit_loss_chart_data_profit;
            } else if ($label_name == 'lossPercentage') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [5,7];
                $profit_loss_chart_data = $profit_loss_chart_data_loss;
            } else if ($label_name == 'profitValue') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [20000,10000];
                $profit_loss_chart_data = $profit_loss_chart_data_profit;
            } else if ($label_name == 'lossValue') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [7000,8000];
                $profit_loss_chart_data = $profit_loss_chart_data_loss;
            } else if ($label_name == 'deliverersCharge') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [100233,65000];
                $profit_loss_chart_data = $deliverers_revenue;
            } else if ($label_name == 'retailerCharge') {
                // $profit_loss_chart_labels = ['Jul','Aug'];
                // $profit_loss_chart_data = [500000,650000];
                $profit_loss_chart_data = $retailers_revenue;
            }
        }

        return response()->json([
            'profit_loss_chart_labels' => $profit_loss_chart_labels,
            'profit_loss_chart_data' => $profit_loss_chart_data
        ]);
    }

    public function getMetricsAverageChartData(Request $request)
    {
        $type = $request->get('type');

        $average_chart_labels = [];
        $this_month_average_chart_values = [];
        $last_month_average_chart_values = [];

        if ($type == 'driver') {
            $this_month = [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()];
            $last_month = [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()];
            $drivers_count = User::where('user_role', 'driver')->whereHas('driver_profile', function ($driver) {
                return $driver->where('status', 'completed');
            })->count() ?: 1;
            $the_month_orders = Order::whereBetween('created_at', $this_month)->where('status', 'delivered')->count();
            $last_month_orders = Order::whereBetween('created_at', $last_month)->where('status', 'delivered')->count();
            $thisMonthAverage = '€' . ($the_month_orders * 10) / $drivers_count;
            $lastMonthAverage = '€' . ($last_month_orders * 10) / $drivers_count;
            $drivers = User::where('user_role', 'driver')->whereHas('driver_profile', function ($driver) {
                return $driver->where('status', 'completed');
            })->withCount('orders')->whereHas('orders', function ($order) use ($this_month) {
                return $order->whereBetween('created_at', $this_month)->where('status', 'delivered');
            })->orderBy('orders_count')->take(8);
            $average_chart_labels = $drivers->pluck('name')->toArray();
            $this_month_average_chart_values = $drivers->get()->map(function ($item) {
                return '' . $item->orders_count * 10;
            });
            $last_month_average_chart_values = User::whereIn('id', $drivers->pluck('id')->toArray())->withCount('orders')->whereHas('orders', function ($order) use ($last_month) {
                return $order->whereBetween('created_at', $last_month)->where('status', 'delivered');
            })->orderBy('orders_count')->take(8)->get()->map(function ($item) {
                return '' . $item->orders_count * 10;
            });
        } else if ($type == 'retailer') {
            $this_month = [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()];
            $last_month = [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()];
            $retailers_count = User::where('user_role', 'retailer')->whereHas('retailer_profile', function ($retailer) {
                return $retailer->where('status', 'completed');
            })->count() ?: 1;
            $the_month_orders = Order::whereBetween('created_at', $this_month)->where('status', 'delivered')->count();
            $last_month_orders = Order::whereBetween('created_at', $last_month)->where('status', 'delivered')->count();
            $thisMonthAverage = '€' . ($the_month_orders * 10) / $retailers_count;
            $lastMonthAverage = '€' . ($last_month_orders * 10) / $retailers_count;
            $retailers = User::where('user_role', 'retailer')->whereHas('retailer_profile', function ($retailer) {
                return $retailer->where('status', 'completed');
            })->withCount('retailerorders')->whereHas('retailerorders', function ($order) use ($this_month) {
                return $order->whereBetween('created_at', $this_month)->where('status', 'delivered');
            })->orderBy('retailerorders_count')->take(8);
            $average_chart_labels = $retailers->pluck('name')->toArray();
            $this_month_average_chart_values = $retailers->get()->map(function ($item) {
                return '' . $item->retailerorders_count * 10;
            });
            $last_month_average_chart_values = User::whereIn('id', $retailers->pluck('id')->toArray())->withCount('retailerorders')->whereHas('retailerorders', function ($order) use ($last_month) {
                return $order->whereBetween('created_at', $last_month)->where('status', 'delivered');
            })->orderBy('retailerorders_count')->take(8)->get()->map(function ($item) {
                return '' . $item->retailerorders_count * 10;
            });
        } else if ($type == 'region') {
            $average_chart_labels = array('region 1', 'region 2', 'region 3', 'region 4', 'region 5', 'region 6', 'region 7', 'region 8');
            $this_month_average_chart_values = array(4000, 7000, 10000, 6000, 1000, 2000, 5000, 3000);
            $last_month_average_chart_values = array(3000, 7000, 9000, 2000, 3000, 4000, 11000, 3000);
            $thisMonthAverage = '€700,000';
            $lastMonthAverage = '€800,000';
        }


        return response()->json([
            'type' => $request->get('type'),
            'average_chart_labels' => $average_chart_labels,
            'last_month_average_chart_values' => $last_month_average_chart_values,
            'this_month_average_chart_values' => $this_month_average_chart_values,
            'thisMonthAverage' => $thisMonthAverage,
            'lastMonthAverage' => $lastMonthAverage
        ]);
    }

    private function adminMetricsDashboardData($from_date, $to_date, $default = false)
    {

        $all_orders = Order::query();
        $all_orders = $all_orders->whereBetween('created_at', [
            $from_date,
            $to_date
        ]);
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

        if ($default == false) {
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
            if ($default && $order->status == 'delivered' && $order->driver != null) {
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
        if ($default) {
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
        $annual_chart_data_orders_last = [];
        // $annual_chart_data_revenue = [];
        for ($i = 0; $i < 12; $i++) {
            $current_month = Carbon::parse($startOfYear)->addMonths($i);
            $start_of_month = $current_month->startOfMonth()->toDateTimeString();
            $end_of_month = $current_month->endOfMonth()->toDateTimeString();
            $month_orders = $annual_orders->whereBetween('created_at', [
                $start_of_month,
                $end_of_month
            ]);
            $annual_chart_labels[] = $current_month->format('M');
            $orders_count = count($month_orders);
            $annual_chart_data_orders[] = (string) $orders_count;
            // $annual_chart_data_revenue[] = $orders_count*10;
        }

        // $annual_chart_data_revenue = [2,5,3,4,8,4,2,3,1,0,0,0];
        // Profit & loss chart data
        /*
         * $profit_loss_chart_labels = ['Jul','Aug'];
         * $profit_loss_chart_data_profit = [10000,5000];
         * $profit_loss_chart_data_loss = [5000,2000];
         */
        $profit_loss_chart_labels = [];
        $profit_loss_chart_data_profit = [];
        $profit_loss_chart_data_loss = [];
        $profit = 0;
        $loss = 0;
        $deliverersCharge = 0;
        $retailerCharge = 0;
        $deliverers_revenue = [];
        $retailers_revenue = [];
        for ($i = 2; $i > 0; $i--) {
            $the_month = Carbon::now()->subMonths($i);
            $profit_loss_chart_labels[] = $the_month->shortMonthName;
            $start_of_month = $the_month->startOfMonth()->toDateTimeString();
            $end_of_month = $the_month->endOfMonth()->toDateTimeString();
            $the_month_orders = Order::whereBetween('created_at', [
                $start_of_month,
                $end_of_month
            ])->get();
            $the_month_revenue = count($the_month_orders) * 10;
            $the_month_profit = $the_month_revenue / 2;
            $the_month_loss = $the_month_revenue / 2;
            $profit_loss_chart_data_profit[] = $the_month_profit;
            $profit_loss_chart_data_loss[] = 0; // $the_month_loss;//0 temporarily
            $profit += $the_month_profit;
            $loss += 0; // $the_month_loss;//0 temporarily
            $deliverersCharge += $the_month_loss;
            $retailerCharge += $the_month_revenue;
            $deliverers_revenue[] = $the_month_loss;
            $retailers_revenue[] = $the_month_revenue;
        }
        $profit_inc_dec = ($profit_loss_chart_data_profit[1] - $profit_loss_chart_data_profit[0]) / ($profit_loss_chart_data_profit[0] > 0 ? $profit_loss_chart_data_profit[0] : 1);
        $profitPercentage = round($profit_inc_dec * 100, 2);
        $profitPercentage = (($profitPercentage < 0) ? '' : '+') . $profitPercentage . '%';
        $loss_inc_dec = ($profit_loss_chart_data_loss[1] - $profit_loss_chart_data_loss[0]) / ($profit_loss_chart_data_loss[0] > 0 ? $profit_loss_chart_data_loss[0] : 1);
        $lossPercentage = round($loss_inc_dec * 100, 2);
        $lossPercentage = (($lossPercentage < 0) ? '' : '+') . $lossPercentage . '%';
        $profit = '€' . $profit;
        $loss = '€' . $loss;
        $deliverersCharge = '€' . $deliverersCharge;
        $retailerCharge = '€' . $retailerCharge;
        $deliverers_rev_inc_dec = ($deliverers_revenue[1] - $deliverers_revenue[0]) / ($deliverers_revenue[0] > 0 ? $deliverers_revenue[0] : 1);
        $deliverersRevenuePercentage = round($deliverers_rev_inc_dec * 100, 2);
        $deliverersRevenuePercentage = (($deliverersRevenuePercentage < 0) ? '' : '+') . $deliverersRevenuePercentage . '%';
        $retailers_rev_inc_dec = ($retailers_revenue[1] - $retailers_revenue[0]) / ($retailers_revenue[0] > 0 ? $retailers_revenue[0] : 1);
        $retailersRevenuePercentage = round($retailers_rev_inc_dec * 100, 2);
        $retailersRevenuePercentage = (($retailersRevenuePercentage < 0) ? '' : '+') . $retailersRevenuePercentage . '%';
        /*
         * $profitPercentage = '+60%';
         * $lossPercentage = '0%';
         * $profit = '€650';
         * $loss = '€29,000';
         * $deliverersCharge = '€233,600';
         * $retailerCharge = '€2,480,00';
         * $deliverersRevenuePercentage = '+40%';
         * $retailersRevenuePercentage = '+60%';
         */

        //
        $thisWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->startOfWeek()->toDateTimeString(), Carbon::now()->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count();
        $lastWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek()->toDateTimeString(), Carbon::now()->subWeek()->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $lastlastWeekPercentage = Order::whereBetween('created_at', [Carbon::now()->subWeeks(2)->startOfWeek()->toDateTimeString(), Carbon::now()->subWeeks(2)->endOfWeek()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $thisWeekPercentage = (($thisWeekPercentage - $lastWeekPercentage) / $lastWeekPercentage) * 100;
        $lastWeekPercentage = (($lastWeekPercentage - $lastlastWeekPercentage) / $lastlastWeekPercentage) * 100;


        $thisMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count();
        $lastMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $lastlastMonthPercentage = Order::whereBetween('created_at', [Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString(), Carbon::now()->subMonths(2)->endOfMonth()->toDateTimeString()])->where('status', 'delivered')->count() ?: 1;
        $thisMonthPercentage = (($thisMonthPercentage - $lastMonthPercentage) / $lastMonthPercentage) * 100;
        $lastMonthPercentage = (($lastMonthPercentage - $lastlastMonthPercentage) / $lastlastMonthPercentage) * 100;

        $this_month = [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()];
        $last_month = [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()];
        $drivers_count = User::where('user_role', 'driver')->whereHas('driver_profile', function ($driver) {
            return $driver->where('status', 'completed');
        })->count() ?: 1;
        $the_month_orders = Order::whereBetween('created_at', $this_month)->where('status', 'delivered')->count();
        $last_month_orders = Order::whereBetween('created_at', $last_month)->where('status', 'delivered')->count();
        $thisMonthAverage = '€' . ($the_month_orders * 10) / $drivers_count;
        $lastMonthAverage = '€' . ($last_month_orders * 10) / $drivers_count;
        $drivers = User::where('user_role', 'driver')->withCount('orders')->whereHas('orders', function ($order) use ($this_month) {
            return $order->whereBetween('created_at', $this_month)->where('status', 'delivered');
        })->orderBy('orders_count')->take(8);
        $average_chart_labels = $drivers->pluck('name')->toArray();
        $this_month_average_chart_values = $drivers->get()->map(function ($item) {
            return '' . $item->orders_count * 10;
        });
        $last_month_average_chart_values = User::whereIn('id', $drivers->pluck('id')->toArray())->withCount('orders')->whereHas('orders', function ($order) use ($last_month) {
            return $order->whereBetween('created_at', $last_month)->where('status', 'delivered');
        })->orderBy('orders_count')->take(8)->get()->map(function ($item) {
            return '' . $item->orders_count * 10;
        });

        return [
            'all_orders_count' => $all_orders_count,
            'delivered_orders_count' => $delivered_orders_count,
            'retailers_count' => $retailers_count,
            'deliverers_count' => $deliverers_count,
            'retailers_order_charges' => $retailers_order_charges,
            'deliverers_order_charges' => $deliverers_order_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data_orders' => $annual_chart_data_orders,
            'annual_chart_data_orders_last' => $annual_chart_data_orders_last,
            'profitPercentage' => $profitPercentage,
            'lossPercentage' => $lossPercentage,
            'profit' => $profit,
            'loss' => $loss,
            'deliverersCharge' => $deliverersCharge,
            'retailerCharge' => $retailerCharge,
            'profit_loss_chart_labels' => $profit_loss_chart_labels,
            'profit_loss_chart_data_profit' => $profit_loss_chart_data_profit,
            'profit_loss_chart_data_loss' => $profit_loss_chart_data_loss,
            'deliverersRevenuePercentage' => $deliverersRevenuePercentage,
            'retailersRevenuePercentage' => $retailersRevenuePercentage,

            'thisWeekPercentage' => $thisWeekPercentage,
            'lastWeekPercentage' => $lastWeekPercentage,
            'thisMonthPercentage' => $thisMonthPercentage,
            'lastMonthPercentage' => $lastMonthPercentage,
            'thisMonthAverage' => $thisMonthAverage,
            'lastMonthAverage' => $lastMonthAverage,
            'average_chart_labels' => $average_chart_labels,
            'this_month_average_chart_values' => $this_month_average_chart_values,
            'last_month_average_chart_values' => $last_month_average_chart_values
        ];
    }
}
