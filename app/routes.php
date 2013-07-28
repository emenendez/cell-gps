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

Route::get('login', function() {
	// Show login form
	return View::make('login');
});

Route::get('login/guest', array('as' => 'login-guest', function() {
	// Log in as guest
	Auth::loginUsingId(1);
	return Redirect::intended('/');
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

	Route::post('login', function() {
		// Process login form
	});

	// Process registration form
	Route::post('signup', array('as' => 'register-submit', 'uses' => 'UserController@processRegistration'));

});