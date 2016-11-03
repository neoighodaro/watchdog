<?php

namespace App\Providers;

use App\Service;
use App\Service\CheckerInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [],
        'Illuminate\Auth\Events\Attempting' => [],
        'Illuminate\Auth\Events\Authenticated' => [],
        'Illuminate\Auth\Events\Login' => [],
        'Illuminate\Auth\Events\Logout' => [],
        'Illuminate\Auth\Events\Lockout' => [],
        'App\Events\WatchdogCheckFailed' => []
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->loadPluginEvents();
    }

    protected function loadPluginEvents()
    {
        $path = plugin_path();

        foreach (glob($path.'/*/Events/*.php') as $file) {
            $event = 'App\Events\WatchdogCheckFailed';

            // Get the class name here...

            $className = "App\\Plugin\\Slack\\Events\\WatchdogCheckFailed";

            Event::listen($event, function ($event) use ($className) {
                $handler = new $className($event);
                $handler->handle();
            });
        }
    }
}
