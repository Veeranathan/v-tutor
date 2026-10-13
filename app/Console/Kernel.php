<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        \App\Console\Commands\SendPushNotification::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('availability:refresh')->dailyAt('01:00')->withoutOverlapping(); // or any preferred time
        $schedule->command('push:send')->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('recordings:process')->hourly()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
