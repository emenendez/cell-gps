<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Routes that require authentication
Route::group(array('before' => 'auth'), function()
{

	Route::get('/', function()
	{
		// Display list of phones with most recent location for current user
		return View::make('phones');
	});

	Route::get('phone/{id}', array('as' => 'phone', function($id) {
		// Display all locations for a phone
	}))->where('id', '[0-9]+');
	
	// Routes that also require csrf
	Route::group(array('before' => 'csrf'), function()
	{

		Route::post('/', function() {
			// Send SMS
		});

	});

});

Route::get('login', function() {
	// Show login form
	return View::make('login');
});

Route::get('login/guest', array('as' => 'login-guest', function() {
	// Log in as guest
	Auth::loginUsingId(1);
	return Redirect::intended('/');
}));

Route::get('signup', function() {
	// Show registration form
});

Route::get('logout', array('as' => 'logout', function() {
	// Log out
	Auth::logout();
	return Redirect::to('/');
}));

// Routes that require csrf
Route::group(array('before' => 'csrf'), function()
{

	Route::post('login', function() {
		// Process login form
	});

	Route::post('signup', function() {
		// Process registration form
	});

});