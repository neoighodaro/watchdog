<?php

namespace App\Http\Controllers;

use App\Service;
use App\Http\Requests;

class StatusController extends Controller {

    public function index()
    {
        $pageStatus = (new Service)->fullStatus();

        $services   = Service::all();

        return view('status', [
            'services'   => $services,
            'pageStatus' => array_get($pageStatus, 'healthStatus'),
        ]);
    }
}
