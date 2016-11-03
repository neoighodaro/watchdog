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
        echo "Send Slack Notification";
    }
}