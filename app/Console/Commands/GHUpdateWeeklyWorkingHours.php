<?php

namespace App\Console\Commands;

use App\Contractor;
use App\Helpers\TwilioHelper;
use Illuminate\Console\Command;

class GHUpdateWeeklyWorkingHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh_drivers_update_working_hours:cron {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly Update for the drivers Working Hours';

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
     * @return mixed
     */
    public function handle()
    {
        $contractors = Contractor::where('status', 'completed')->get(['name','phone_number']);
        foreach ($contractors as $contractor) {
            $message = '';
            if ($this->argument('type') != null) {
                $message = "Hi $contractor->name, this is a reminder to update your weekly working hours if you haven't already";
            } else {
                $message = "Hey $contractor->name, Please click on the following link to update your weekly working days and hours with GardenHelp. https://iot.bumblebeeai.io/contractors_app#/update-working-hours";
            }
            TwilioHelper::sendSMS('GardenHelp', $contractor->phone_number, $message);
        }
    }
}
