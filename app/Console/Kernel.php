<?php

namespace App\Console;

use App\Console\Commands\UpdateOrderStatusJob;
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
        Commands\ChargeRetailerManual::class,
        Commands\PayoutDeliverer::class,
        Commands\GHUpdateWeeklyWorkingHours::class,
        UpdateOrderStatusJob::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('chargeretailer:cron')->daily();
        // $schedule->command('payoutdeliverer:cron')->hourly();
        $schedule->command('gardenhelpcustomerpaymentintent:cron')->daily();
        $schedule->command('gh_drivers_update_working_hours:cron')->weeklyOn(5, '11:00');
        $schedule->command('gh_drivers_update_working_hours:cron reminder')->weeklyOn(1, '09:30');
        $schedule->command('gh-recurring-jobs:cron')->dailyAt('12:30');
        $schedule->command('update:order')->everyFifteenMinutes();
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
