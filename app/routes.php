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

// List of providers
View::composer('master', function($view)
{
	$providers = array(
		'' => 'Other',
		'message.alltel.com' => 'Alltel',
		'txt.att.net' => 'AT&T',
		'txt.bellmobility.ca' => 'Bell Canada',
		'myboostmobile.com' => 'Boost Mobile',
		'sms.mycricket.com' => 'Cricket',
		'messaging.nextel.com' => 'Nextel (now Sprint Nextel)',
		'pcs.ntelos.com' => 'nTelos',
		'messaging.sprintpcs.com' => 'Sprint (now Sprint Nextel)',
		'tmomail.net' => 'T-Mobile',
		'email.uscc.net' => 'US Cellular',
		'vtext.com' => 'Verizon',
		'vmobl.com' => 'Virgin Mobile'
		);
    $view->with('providers', $providers);
	$view->with('provider', Input::old('provider', ''));
	$view->with('phone', Input::old('phone', ''));
	$view->with('gateway', Input::old('gateway', ''));
	$view->with('subject', Input::old('subject', ''));
	$view->with('message', Input::old('message', ''));
});

// Route models
Route::model('phone', 'Phone');

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
			Route::post('/', array('as' => 'send-sms', 'uses' => 'PhoneController@sendSMS'));
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

Route::pattern('token', '[0-9A-Za-z\-_]+');

// Get location from subject device
Route::get('/update/{token}/{longitude}/{latitude}/{altitude}/{accuracy}/{altitudeAccuracy}/{heading}/{speed}/{location_time}',
	array('as' => 'set-location', 'uses' => 'PhoneController@setLocation'));

// Prompt subject for location
Route::get('/{token?}', array('as' => 'get-location', 'uses' => 'PhoneController@getLocation'));
