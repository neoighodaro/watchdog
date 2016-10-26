<?php

namespace App\Console;

use App\Service\Watchdog;
use App\Service as ServiceModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $services = app('cache')->remember('services.schedule', 5, function () {
            return ServiceModel::all();
        });

        foreach ($services as $service) {
            $schedule->call(function () use ($service) {
                $status = (new Watchdog($service))->check();

                // Update the status...
                dd($status);
            })
            ->cron($service->cron)
            ->name(str_slug($service->name))
            ->withoutOverlapping();
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
