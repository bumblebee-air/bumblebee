<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ChargeRetailer::class,
        Commands\PayoutDeliverer::class,
        Commands\GHUpdateWeeklyWorkingHours::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('chargeretailer:cron')->monthly();
        $schedule->command('gardenhelpcustomerpaymentintent:cron')->daily();
        $schedule->command('gh_drivers_update_working_hours:cron')->weeklyOn(1, '8:45');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
