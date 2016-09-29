<?php

// ---------------------------------------------------------------------
// Authenticate
// ---------------------------------------------------------------------

$router->get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
$router->post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
$router->get('login',  ['uses' => 'GuestController@login']);


// ---------------------------------------------------------------------
// Misc.
// ---------------------------------------------------------------------

$router->get('/', ['as' => 'home', 'uses' => 'GuestController@welcome']);
