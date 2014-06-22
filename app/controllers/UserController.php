<?php

class UserController extends \BaseController {
	public function showRegistration() {
		$user = new User;

		return View::make('register', array('user' => $user));
	}

	public function processRegistration() {
    	// Validate input
		$validator = Validator::make(
			Input::all(), 
			array(
				'email' => array('required', 'email', 'unique:users'),
				'password' => array('required', 'confirmed'),
				));

		if ($validator->fails())
	    {
	        return Redirect::back()->withErrors($validator)->withInput();
	    }

	    $user = new User;
	    $user->email = Input::get('email');
	    $user->password = Hash::make(Input::get('password'));
	    $user->organization = Input::get('organization');
	    $user->save();

	    Auth::login($user);

	    return Redirect::route('index');
	}

	public function showLogin() {
		$email = Input::get('email');
		return View::make('login')->with(array('error' => Session::get('error'), 'email' => $email));
	}

	public function processLogin() {
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
		{
			// $user = Auth::user();
			// $user->last_login = now();
			// $user->save();
		    return Redirect::intended('index');
		}

		return Redirect::back()->with('error', 'Incorrect user and/or password.')->withInput();
	}

}
