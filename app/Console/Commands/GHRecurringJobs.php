<?php

namespace App\Console\Commands;

use App\Customer;
use App\Helpers\TwilioHelper;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GHRecurringJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh-recurring-jobs:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are recurring jobs';

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
        $jobs = Customer::where('status', 'completed')->where('is_recurring', true)->get();

        foreach ($jobs as $job) {
            $jobFrequency = $job->frequency;
            $now = Carbon::now();
            $recurringJobData = Carbon::parse($job->available_date_time)->addMonths($jobFrequency);
            if ($now->toDateString() == $recurringJobData->subWeeks(2)->toDateString()) {
                $new_job = $job->replicate();
                $new_job->status = 'quote_sent';
                $new_job->contractor_id = null;
                $new_job->available_date_time = $recurringJobData;
                $new_job->save();

                //Make the previous job not recurring
                $job->is_recurring = false;
                $job->save();

                $body = "Hi $new_job->name, Gardenhelp service will be recurring, please visit the following link to enter the card details and schedule date. " .env('APP_URL', 'https://iot.bumblebeeai.io') . "/service-booking/$new_job->id";
                TwilioHelper::sendSMS('GardenHelp', '+201005088541', $body);
            }
        }
    }
}
