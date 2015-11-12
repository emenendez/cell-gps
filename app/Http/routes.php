<?php

use App\User;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * All routes used by SAR
 */
Route::group(array('prefix' => '~admin'), function()
{

	// Routes that require authentication
	Route::group(array('middleware' => 'auth'), function()
	{
		// Display static admin page
		Route::get('/', ['as' => 'index', 'uses' => 'AdminController@getIndex']);

		// RESTful API routes
		Route::resource('phones', 'PhoneController');
		Route::resource('messages', 'MessageController', ['except' => ['edit', 'destroy'], 'names' => ['store' => 'messages.store']]);
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

	// Process login
	Route::post('login', array('as' => 'login-submit', 'uses' => 'UserController@processLogin')); 

	// Process registration form
	Route::post('signup', array('as' => 'register-submit', 'uses' => 'UserController@processRegistration'));

});

/**
 * All routes used by the search subject
 */

Route::pattern('token', '[0-9A-Za-z\-_]+');

Route::group(array('middleware' => 'DisableSessions'), function()
{
	// Get location from subject device
	Route::get('/update/{token}/{longitude}/{latitude}/{altitude}/{accuracy}/{altitudeAccuracy}/{heading}/{speed}/{location_time}',
		array('as' => 'set-location', 'uses' => 'PhoneController@setLocation'));

	// Prompt subject for location
	Route::get('/{token?}', array('as' => 'get-location', 'uses' => 'PhoneController@getLocation'));
});
