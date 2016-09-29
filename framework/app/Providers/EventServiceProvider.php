<?php

namespace App\Providers;

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
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
