<?php
Route::get('/', function () {
    return view('welcome');
});
Route::get('/tes', function () {
	$user = \App\User::find(2);
	return new \App\Mail\Admin\ForgotMail($user);
});

routeController('login','Admin\LoginController');
Route::get('login','Admin\LoginController@getIndex')->name('login');
\Admin::displayRoutes();
