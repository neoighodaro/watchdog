<?php

namespace App\Plugin\Slack\Events;

use App\Events\WatchdogCheckFailed;

class WatchdogCheckFailed {

    /**
     * Event instance.
     *
     * @var WatchdogCheckFailed
     */
    protected $event;

    /**
     * Class constructor.
     *
     * @param WatchdogCheckFailed $event
     */
    public function __construct(WatchdogCheckFailed $event)
    {
        $this->event = $event;
    }

    /**
     * Handle the event.
     *
     * @return null
     */
    public function handle()
    {
        // Check last few responses...
        // -----
        // $this->event->response
        // $this->event->service

        // Fetch error description
        $description = $this->event->response->description();

        dd($this->event->service->with(['statuses' => function ($query) {
            $query->take(1);
        }])->statuses()->get());

        // Should only send notifications if there are 2 breakages in a row...
        echo "Send Slack Notification";
    }
}