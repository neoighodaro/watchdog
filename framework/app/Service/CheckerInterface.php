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

}