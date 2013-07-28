<?php

class UserController extends BaseController {
	public function showRegistration() {
		$user = new User;

		return View::make('register', array('user' => $user));
	}

	public function processRegistration() {
		// Make input available in future requests
    	Input::flash();

    	// Validate input
		$validator = Validator::make(
			Input::all(), 
			array(
				'email' => array('required', 'email', 'unique:users'),
				'password' => array('required', 'confirmed'),
				));

		if ($validator->fails())
	    {
	        return Redirect::back()->withErrors($validator);
	    }

	    $user = User::create(Input::all());

	    Auth::login($user);

	    return Redirect::route('index');
	}

}
