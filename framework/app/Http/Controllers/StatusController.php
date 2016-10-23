<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests;

class StatusController extends Controller {

    public function index()
    {
        $pageStatus = App\Status::HEALTHY;

        $services   = App\Service::all();

        return view('status', [
            'services'   => $services,
            'pageStatus' => $pageStatus,
        ]);
    }
}
