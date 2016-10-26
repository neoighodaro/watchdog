<?php

namespace App\Http\Controllers;

use App\Service;
use App\Http\Requests;

class StatusController extends Controller {

    public function index()
    {
        $service = new Service;
        $summary = $service->fullStatus();

        return view('status', [
            'summary'    => $summary,
            'services'   => $service->all(),
            'pageStatus' => array_get($summary, 'healthStatus'),
        ]);
    }
}
