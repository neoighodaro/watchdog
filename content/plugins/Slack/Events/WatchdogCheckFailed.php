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
        // Should only send notifications if there are 2 breakages in a row...
        echo "Send Slack Notification";
    }
}