<?php

namespace App\Service;

use App\Service;

interface CheckerInterface {

    /**
     * Check the service.
     *
     * @param  Service $service
     * @return integer
     */
    function check(Service $service);

    /**
     * Get the status of the service.
     *
     * @return integer
     */
    function status();

    /**
     * Get the description of the error.
     *
     * @return string
     */
    function description();
}