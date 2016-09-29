<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::post('/login', [
    'as'   => 'login',
    'uses' => 'Auth\LoginController@login'
]);

Route::get('/login', function () {
    return redirect()->home();
});

Route::get('/', ['as' => 'home', function () {
    return view('welcome');
}]);
