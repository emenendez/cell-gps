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

// Keep old fields populated in master view
View::composer('master', function($view)
{
	$view->with('phone', Input::old('phone', ''));
	$view->with('message', Input::old('message', ''));
});

// Route models
Route::model('phone', 'Phone');

/**
 * All routes used by SAR
 */
Route::group(array('prefix' => '~admin'), function()
{

	// Routes that require authentication
	Route::group(array('before' => 'auth'), function()
	{

		Route::get('/', array('as' => 'index', 'uses' => 'PhoneController@showPhones'));

		// Display all locations for a phone
		Route::get('phone/{phone}', array('as' => 'phone', 'uses' => 'PhoneController@showPhone'))->where('phone', '[0-9]+');
		
		// Routes that also require csrf
		Route::group(array('before' => 'csrf'), function()
		{
			// Send SMS
			Route::post('/', array('as' => 'send-sms', 'uses' => 'MessageController@send'));
		});

	});

	// Show login form
	Route::get('login', array('as' => 'login', 'uses' => 'UserController@showLogin'));

	Route::get('login/guest', array('as' => 'login-guest', function() {
		// Log in as guest
		Auth::login(User::Guest());
		UserController::touchUser();
		return Redirect::intended(route('index'));
	}));

	// Show registration form
	Route::get('signup', array('as' => 'register', 'uses' => 'UserController@showRegistration'));

	Route::get('logout', array('as' => 'logout', function() {
		// Log out
		Auth::logout();
		return Redirect::route('index');
	}));

	// Routes that require csrf
	Route::group(array('before' => 'csrf'), function()
	{
		// Process login
		Route::post('login', array('as' => 'login-submit', 'uses' => 'UserController@processLogin')); 

		// Process registration form
		Route::post('signup', array('as' => 'register-submit', 'uses' => 'UserController@processRegistration'));

	});

});

/**
 * All routes used by the search subject
 */

Route::pattern('token', '[0-9A-Za-z\-_]+');

Route::group(array('before' => array('session.remove')), function()
{
	// Get location from subject device
	Route::get('/update/{token}/{longitude}/{latitude}/{altitude}/{accuracy}/{altitudeAccuracy}/{heading}/{speed}/{location_time}',
		array('as' => 'set-location', 'uses' => 'PhoneController@setLocation'));

	// Prompt subject for location
	Route::get('/{token?}', array('as' => 'get-location', 'uses' => 'PhoneController@getLocation'));
});
