<?php

namespace App\Jobs;

use App\Contractor;
use App\Customer;
use App\Helpers\TwilioHelper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewJobNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $job_request;

    public function __construct(Customer $job)
    {
        $this->job_request = $job;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //Notify the contractors if there is a new job
            $contractors = Contractor::all();
            $currentDayName = Carbon::createFromFormat('d/m/Y H:i A', $this->job_request->available_date_time)->format('l');
            foreach ($contractors as $contractor) {
                if ($contractor->business_hours_json) {
                    $contractor_business_hours = json_decode($contractor->business_hours_json, true);
                    if($contractor_business_hours[$currentDayName]['isActive']){
                        $contractor_name = $contractor->user->name;
                        TwilioHelper::sendSMS('GardenHelp', $contractor->user->phone, "Hi $contractor_name, There is a new job waiting for you, click on the following link to view the job details: ". url("contractors_app/#/order-details").'/'. $this->job_request->id);
                    }
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
