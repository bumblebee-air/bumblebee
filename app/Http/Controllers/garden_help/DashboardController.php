<?php
namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Contractor;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $ajax_flag = $request->get('from_date') ? true : false;
        $default = $request->get('from_date') ? false : true;
        $from_date = $request->get('from_date') ? new Carbon($request->get('from_date')) : Carbon::now()->startOfDay()->toDateTimeString();
        $to_date = $request->get('to_date') ? new Carbon($request->get('to_date')) : Carbon::now()->endOfDay()->toDateTimeString();

        $admin_data = $this->adminDashboardData($from_date, $to_date, $default);

        
        if ($ajax_flag == true) {
            return response()->json($admin_data);
        }
        
        
        $commercial_jobs_count = $admin_data['commercial_jobs_count'];
        $residential_jobs_count = $admin_data['residential_jobs_count'];
        $contractors_count = $admin_data['contractors_count'];
        $new_customers_count = $admin_data['new_customers_count'];

        $contractors_charges = $admin_data['contractors_charges'];
        $customers_charges = $admin_data['customers_charges'];
        
        
        $annual_chart_labels = $admin_data['annual_chart_labels'];
        $annual_chart_data = $admin_data['annual_chart_data'];
        $annual_chart_data_last = $admin_data['annual_chart_data_last'];
        $thisWeekPercentage = round($admin_data['thisWeekPercentage'],2);
        $lastWeekPercentage = round($admin_data['lastWeekPercentage'],2);
        $thisMonthPercentage =round( $admin_data['thisMonthPercentage'],2);
        $lastMonthPercentage = round($admin_data['lastMonthPercentage'],2);

        return view('admin.garden_help.dashboard', compact('commercial_jobs_count', 'residential_jobs_count', 'contractors_count', 'new_customers_count',
            'contractors_charges', 'customers_charges', 'annual_chart_labels', 'annual_chart_data', 'annual_chart_data_last',
            'thisWeekPercentage', 'lastWeekPercentage', 'thisMonthPercentage', 'lastMonthPercentage'));
    }

    private function adminDashboardData($from_date, $to_date, $default = false)
    {
        $commercial_jobs_count = Customer::where('type_of_work', 'Commercial')->whereBetween('created_at', [
            $from_date,
            $to_date
        ])->count();
        $residential_jobs_count = Customer::where('type_of_work', 'Residential')->whereBetween('created_at', [
            $from_date,
            $to_date
        ])->count();

        if ($default) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfMonth()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfMonth()
                ->endOfDay()
                ->toDateTimeString();
        }
        $contractors_count = Contractor::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->count();
        $new_customers_count = Customer::where('type', 'request')->whereBetween('created_at', [
            $from_date,
            $to_date
        ])->count();

        /**
         * ******************** table data ********************
         */
        $contractors_charges = [
            (object) [
                'name' => 'Spellman Callaghan',
                'job_count' => 6,
                'charge' => '€600'
            ],
            (object) [
                'name' => 'ACCA Ireland',
                'job_count' => 3,
                'charge' => '€300'
            ]
        ];
        $customers_charges = [
            (object) [
                'name' => 'Mossie Fitzpatrick',
                'job_count' => 3,
                'charge' => '€30'
            ],
            (object) [
                'name' => 'Brian O Neill',
                'job_count' => 6,
                'charge' => '€60'
            ]
        ];

        /**
         * ************ chart data ******************
         */
        $current_date = Carbon::now();
        $last_year_date = Carbon::now()->subWeeks(52);
        
        $startOfYear = $current_date->startOfYear()->toDateTimeString();
        $endOfYear = $current_date->endOfYear()->toDateTimeString();
        
        $startOfLastYear = $last_year_date->startOfYear()->toDateTimeString();
        $endOfLastYear = $last_year_date->endOfYear()->toDateTimeString();
        
        $annual_orders = Customer::whereBetween('created_at', [
            $startOfYear,
            $endOfYear
        ])->get();
        $last_annual_orders = Customer::whereBetween('created_at', [
            $startOfLastYear,
            $endOfLastYear
        ])->get();
        
        $annual_chart_labels = [];
        $annual_chart_data = [];
        $annual_chart_data_last = [];
        // $annual_chart_data_revenue = [];
        for ($i = 0; $i < 12; $i ++) {
            $current_month = Carbon::parse($startOfYear)->addMonths($i);
            $start_of_month = $current_month->startOfMonth()->toDateTimeString();
            $end_of_month = $current_month->endOfMonth()->toDateTimeString();
            
            $month_orders = $annual_orders->whereBetween('created_at', [
                $start_of_month,
                $end_of_month
            ]);
            $annual_chart_labels[] = $current_month->format('M');
            $orders_count = count($month_orders);
            $annual_chart_data[] = (string) $orders_count;
            // $annual_chart_data_revenue[] = $orders_count*10;
            
            $current_month_last = Carbon::parse($startOfLastYear)->addMonths($i);
            $start_of_month_last = $current_month_last->startOfMonth()->toDateTimeString();
            $end_of_month_last = $current_month_last->endOfMonth()->toDateTimeString();
            $month_orders_last = $last_annual_orders->whereBetween('created_at', [
                $start_of_month_last,
                $end_of_month_last
            ]);
            $orders_count_last = count($month_orders_last);
            $annual_chart_data_last[] = (string) $orders_count_last;
        }
        
        $thisWeekPercentage = Customer::whereBetween('created_at', [Carbon::now()->startOfWeek()->toDateTimeString(), Carbon::now()->endOfWeek()->toDateTimeString()])->where('status', 'completed')->count();
        $lastWeekPercentage = Customer::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek()->toDateTimeString(), Carbon::now()->subWeek()->endOfWeek()->toDateTimeString()])->where('status', 'completed')->count() ?: 1;
        $lastlastWeekPercentage = Customer::whereBetween('created_at', [Carbon::now()->subWeeks(2)->startOfWeek()->toDateTimeString(), Carbon::now()->subWeeks(2)->endOfWeek()->toDateTimeString()])->where('status', 'completed')->count() ?: 1;
        $thisWeekPercentage = (($thisWeekPercentage - $lastWeekPercentage) / $lastWeekPercentage) * 100;
        $lastWeekPercentage = (($lastWeekPercentage - $lastlastWeekPercentage) / $lastlastWeekPercentage) * 100;
        
        
        $thisMonthPercentage = Customer::whereBetween('created_at', [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()])->where('status', 'completed')->count();
        $lastMonthPercentage = Customer::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->subMonth()->endOfMonth()->toDateTimeString()])->where('status', 'completed')->count() ?: 1;
        $lastlastMonthPercentage = Customer::whereBetween('created_at', [Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString(), Carbon::now()->subMonths(2)->endOfMonth()->toDateTimeString()])->where('status', 'completed')->count() ?: 1;
        $thisMonthPercentage = (($thisMonthPercentage - $lastMonthPercentage) / $lastMonthPercentage) * 100;
        $lastMonthPercentage = (($lastMonthPercentage - $lastlastMonthPercentage) / $lastlastMonthPercentage) * 100;
        
        
        return [
            'commercial_jobs_count' => $commercial_jobs_count,
            'residential_jobs_count' => $residential_jobs_count,
            'contractors_count' => $contractors_count,
            'new_customers_count' => $new_customers_count,
            'contractors_charges' => $contractors_charges,
            'customers_charges' => $customers_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data' => $annual_chart_data,
            'annual_chart_data_last' => $annual_chart_data_last,
            'thisWeekPercentage' => $thisWeekPercentage,
            'lastWeekPercentage' => $lastWeekPercentage,
            'thisMonthPercentage' => $thisMonthPercentage,
            'lastMonthPercentage' => $lastMonthPercentage,
        ];
    }
}
