<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class GuestController extends Controller {

    /**
     * Welcome screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Redirect to the home page as it contains the login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        return redirect()->home();
    }
}
