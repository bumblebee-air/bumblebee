<?php
namespace App\Http\Controllers\unified;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UnifiedJob;
use App\UnifiedEngineer;
use App\UnifiedCustomer;

class DashboardController extends Controller
{

    public function index(Request $request)
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
        $admin_data = $this->adminDashboardData($from_date, $to_date);
        $all_jobs_count = $admin_data['all_jobs_count'];
        $completed_jobs_count = $admin_data['completed_jobs_count'];
        $engineers_count = $admin_data['engineers_count'];
        $customers_count = $admin_data['customers_count'];
        $engineers_jobs_charges = $admin_data['engineers_jobs_charges'];
        $customers_jobs_charges = $admin_data['customers_jobs_charges'];
        $annual_chart_labels = $admin_data['annual_chart_labels'];
        $annual_chart_data = $admin_data['annual_chart_data'];
        $engineers_arr = $admin_data['engineers_arr'];
        if ($ajax_flag == true) {
            return response()->json($admin_data);
        }
        return view('admin.unified.dashboard', compact('engineers_arr', 'all_jobs_count', 'completed_jobs_count', 'engineers_count',
            'customers_count', 'engineers_jobs_charges', 'customers_jobs_charges', 'annual_chart_labels', 'annual_chart_data'));
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
        $all_jobs = UnifiedJob::query();
        $all_jobs = $all_jobs->whereBetween('start_at', [
            $from_date,
            $to_date
        ]);
        if (! $custom_date) {
            $all_jobs = $all_jobs->orWhere(function ($q) use ($from_date, $to_date) {
                $q->whereNotBetween('start_at', [
                    $from_date,
                    $to_date
                ]);
            });
        }
        $all_jobs = $all_jobs->get();

        $all_jobs_count = count($all_jobs);
        $completed_jobs_count = 0;

        if ($custom_date == false) {
            $current_date = Carbon::now();
            $from_date = $current_date->startOfMonth()
                ->startOfDay()
                ->toDateTimeString();
            $to_date = $current_date->endOfMonth()
                ->endOfDay()
                ->toDateTimeString();
        }
        $registered_engineers = UnifiedEngineer::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $registered_customers = UnifiedCustomer::whereBetween('created_at', [
            $from_date,
            $to_date
        ])->get();
        $engineers_count = count($registered_engineers);
        $customers_count = count($registered_customers);

        $customers_jobs_charges = [
            (object)[
                'customer_name' => 'Spellman Callaghan',
                'job_count' => 6,
                'job_charge' => '€600'
            ],
            (object)[
                'customer_name' => 'ACCA Ireland',
                'job_count' => 3,
                'job_charge' => '€300'
            ]
        ];
        $engineers_jobs_charges = [
            (object)[
                'engineer_name' => 'Mossie Fitzpatrick',
                'job_count' => 3,
                'job_charge' => '€30'
            ],
            (object)[
                'engineer_name' => 'Brian O Neill',
                'job_count' => 6,
                'job_charge' => '€60'
            ]
        ];

        // Annual orders data
        // $current_date = Carbon::now()->subYear();
        $current_date = Carbon::now();
        $startOfYear = $current_date->startOfYear()->toDateTimeString();
        $endOfYear = $current_date->endOfYear()->toDateTimeString();
        $annual_orders = UnifiedJob::whereBetween('start_at', [
            $startOfYear,
            $endOfYear
        ])->get();
        $annual_chart_labels = [];
        $annual_chart_data = [];
        for ($i = 0; $i < 12; $i ++) {
            $current_month = Carbon::parse($startOfYear)->addMonths($i);
            $start_of_month = $current_month->startOfMonth()->toDateTimeString();
            $end_of_month = $current_month->endOfMonth()->toDateTimeString();
            $month_orders = $annual_orders->whereBetween('start_at', [
                $start_of_month,
                $end_of_month
            ]);
            $annual_chart_labels[] = $current_month->format('M');
            $annual_chart_data[] = (string) count($month_orders);
        }

        $engineers_arr[] = [
            'engineer' => [
                'name' => "Adam Baxter",
                'id' => 2
            ],
            'lat' => 53.25755,
            'lon' => - 9.08699,
            'timestamp' => '2021-08-10 15:42:23'
        ];

        $engineers_arr = json_encode($engineers_arr);
        return [
            'engineers_arr' => $engineers_arr,
            'all_jobs_count' => $all_jobs_count,
            'completed_jobs_count' => $completed_jobs_count,
            'engineers_count' => $engineers_count,
            'customers_count' => $customers_count,
            'customers_jobs_charges' => $customers_jobs_charges,
            'engineers_jobs_charges' => $engineers_jobs_charges,
            'annual_chart_labels' => $annual_chart_labels,
            'annual_chart_data' => $annual_chart_data
        ];
    }
}
