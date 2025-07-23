<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('lawyer:status-off')->dailyAt('22:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        $this->commands([
            \App\Console\Commands\SetLawyerStatusOffline::class,
        ]);

        require base_path('routes/console.php');
    }
}
