<?php

namespace App\Http\Controllers;

use App\Service;
use App\Http\Requests;

class StatusController extends Controller {

    public function index()
    {
        $service = new Service;
        $summary = $service->fullStatus(60*24*31);

        return view('status', [
            'summary'    => $summary,
            'services'   => $service->all(),
            'pageStatus' => array_get($summary, 'healthStatus'),
        ]);
    }
}
