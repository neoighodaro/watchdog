<?php

namespace App\Plugin\Slack\Events;

use App\Option;
use Carbon\Carbon;
use App\Plugin\Slack;
use App\Events\WatchdogCheckFailed as WatchdogCheckFailedEvent;

class WatchdogCheckFailed {

    /**
     * Slack notification posting intervals.
     */
    const INTERVALS = 3;

    /**
     * Event instance.
     *
     * @var WatchdogCheckFailed
     */
    protected $event;

    /**
     * Class constructor.
     *
     * @param WatchdogCheckFailedEvent $event
     */
    public function __construct(WatchdogCheckFailedEvent $event)
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
        $service = $this->event->service->with(['statuses' => function ($query) {
            $query->orderBy('created_at', 'desc')->take(2);
        }])->find($this->event->service->id);

        if ($service) {
            $maximumFailure = 0;

            foreach ($service->statuses as $status) {
                if ( ! $status->isResponseOk()) $maximumFailure++;
            }

            $description = $this->event->response->description();

            if ($maximumFailure >= 1) {
                return $this->brokenMoreThanOnceEvent($service, $description);
            }

            return $this->brokenJustOnceEvent($service, $description);
        }
    }

    /**
     * Fire event if the service has been broken more than once.
     *
     * @param  Service $service
     * @param  string  $description
     * @return null
     */
    protected function brokenMoreThanOnceEvent($service, $description)
    {
        $errorMessage  = "Seems there's something up with \"{$service->name} ({$service->url})";
        $errorMessage .= "\n{$description}";

        return $this->postNotification("_Woof!!! Watchdog encountered an issue connecting to one of the services... @channel_", [
            'color' => 'danger',
            'title' => 'Houston, we have a problem!',
            'text' => $errorMessage,
            'fallback_text' => $errorMessage,
        ]);
    }

    /**
     * Fire event if the service has been broken just once.
     *
     * @param  Service $service
     * @param  string  $description
     * @return null
     */
    protected function brokenJustOnceEvent($service, $description)
    {
        // Stub
    }

    /**
     * Post notification to slack.
     *
     * @param  string $msg
     * @param  array  $attachments
     * @return null|array
     */
    protected function postNotification($msg, array $attachments = [])
    {
        if ($this->shouldPostNotification()) {
            $post = (new Slack\Notification)->postChatMessage($msg, [
                'channel'     => env('SLACK_POST_CHANNEL'),
                'icon_url'    => asset('img/watchdog@2x.png'),
                'attachments' => json_encode([$attachments]),
            ]);

            if ($post['status'] === 'success') {
                $timestamp = (int) strtotime(Carbon::now()->toDateTimeString());

                (new Option)->setOption('_slack_last_posted', $timestamp);
            }

            return $post;
        }

        return null;
    }

    /**
     * Check if Slack should post a notification. To avoid spamming the channel you
     * should only post once every x minutes.
     *
     * @return boolean
     */
    protected function shouldPostNotification()
    {
        if ($timestamp = (new Option)->getOption('_slack_last_posted')) {
            $lastPostedTime = Carbon::createFromTimestamp($timestamp);

            $currentTime = Carbon::now();

            return $lastPostedTime->diffInMinutes($currentTime) >= static::INTERVALS;
        }

        return true;
    }
}