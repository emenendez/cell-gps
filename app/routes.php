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

Route::get('/', function()
{
	// Display list of phones with most recent location for current user
	return View::make('phones');
});

Route::post('/', function() {
	// Send SMS
});

Route::get('phone/{id}', array('as' => 'phone', function($id) {
	// Display all locations for a phone
}))->where('id', '[0-9]+');

Route::get('login', function() {
	// Show login form
});

Route::post('login', function() {
	// Process login form
});

Route::get('signup', function() {
	// Show registration form
});

Route::post('signup', function() {
	// Process registration form
});