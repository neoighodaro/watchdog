<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class StatusController extends Controller {

    public function index()
    {
        return view('status');
    }
}
