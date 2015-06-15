<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\User;

class UserController extends Controller {
	public function showRegistration() {
		$user = new User;
		return view('register', array('user' => $user));
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

	public function showLogin(Request $request) {
		$email = $request->input('email');
		return view('login', ['error' => session('error'), 'email' => $email]);
	}

	static function touchUser()
	{
		$user = Auth::user();
		$user->last_login = Carbon::now();
		$user->save();
	}

	public function processLogin() {
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
		{
			UserController::touchUser();
		    return Redirect::intended(route('index'));
		}

		return Redirect::back()->with('error', 'Incorrect user and/or password.')->withInput();
	}

}
