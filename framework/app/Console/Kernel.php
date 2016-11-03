<?php

namespace App\Console;

use App\Status;
use App\Service\Watchdog;
use App\Service as ServiceModel;
use App\Events\WatchdogCheckFailed;
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
        $cacheTime = config('app.debug') ? 0 : 5;

        $services = app('cache')->remember('services.schedule', $cacheTime, function () {
            return ServiceModel::all();
        });

        foreach ($services as $service) {
            $schedule->call(function () use ($service) {
                $response = (new Watchdog($service))->check();

                if ($response->status() === Watchdog::SERVICE_BAD) {
                    event(new WatchdogCheckFailed($service, $response));
                }

                $service->statuses()->save(new Status([
                    'response'    => $response->status(),
                    'description' => $response->description(),
                ]));
            })
            ->cron($service->cron)
            ->name(str_slug($service->name));
            // ->withoutOverlapping();
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
