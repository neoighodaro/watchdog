<?php

namespace App\Service;

use App\Service as ServiceModel;

/**
 * Class to check for a service status.
 *
 * $watchdog = new App\Service\Watchdog('http', App\Service::find(1));
 * $status   = $watchdog->check();
 *
 * @author Neo Ighodaro <neo@hng.tech>
 */
class Watchdog {

    /**
     * Service status levels
     */

    const SERVICE_OK    = 200;
    const SERVICE_BAD   = 0;
    const SERVICE_ISSUE = 100;

    /**
     * @var CheckerInterface
     */
    protected $driver;

    /**
     * @var ServiceModel
     */
    protected $service;

    /**
     * Class constructor.
     *
     * @param ServiceModel $service
     */
    public function __construct(ServiceModel $service)
    {
        $this->driver = app("watchdog.{$service->type}");

        $this->service = $service;
    }

    /**
     * Check service.
     *
     * @return integer
     */
    public function check()
    {
        return $this->driver->check($this->service);
    }
}
