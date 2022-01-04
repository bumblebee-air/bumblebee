<?php

namespace App\Console\Commands;

use App\ContractorBidding;
use App\Customer;
use App\CustomNotification;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Console\Command;

class GHActivityNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh-activity-notification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is jobs has not activity within specific hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $custom_notifications = CustomNotification::whereHas('client', function ($q) {
            $q->where('name', 'GardenHelp');
        })->where('type', 'activity')->get();
        if (count($custom_notifications) > 0) {
            foreach ($custom_notifications as $custom_notification) {
                $notification_period = $custom_notification->activity_hours;
                $jobs = Customer::where('type', 'job')
                    ->where('status', '=', 'ready')
                    ->where(function ($q) use ($notification_period) {
                        $q->doesntHave('contractors_bidding')->where('created_at', '<', Carbon::now()->subHours($notification_period)->toDateTimeString());
                        $q->orWhereHas('contractors_bidding', function (EloquentBuilder $bidding_query) use ($notification_period) {
                            /*
                             * Getting a record by the created at of the latest record by id in the relation to be matched with time period.
                             *
                             * Copyrights "kondorb" URL: https://laracasts.com/discuss/channels/eloquent/get-model-where-latest-hasmany-equals-a-value?page=1&replyId=606212
                             */
                            $bidding_query->where('created_at', '<', Carbon::now()->subHours($notification_period)->toDateTimeString())
                                ->whereIn('id', function (QueryBuilder $query) {
                                    $query
                                        ->selectRaw('max(id)')
                                        ->from('contractors_bidding')
                                        ->whereColumn('job_id', 'customers_registrations.id');
                                });
                        });
                    })
                    ->get();
//                    ->toSql();
//                    ->dd();
//                dd($jobs);
//                dd($jobs->latest_contractors_bidding->where('created_at', '<', Carbon::now()->subHours($notification_period)->toDateTimeString())->first());
//                dd(Carbon::now()->subHours($notification_period)->toDateTimeString());
                dd(count($jobs), Carbon::now()->subHours($notification_period)->toDateTimeString());
            }
        }
    }
}
