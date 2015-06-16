<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\User;
use Hash;

class UserController extends Controller {
	public function showRegistration() {
		$user = new User;
		return view('register', array('user' => $user));
	}

	public function processRegistration(Request $request) {
    	// Validate input
    	$this->validate($request, [
			'email' => array('required', 'email', 'unique:users'),
			'password' => array('required', 'confirmed'),
		]);

	    $user = new User;
	    $user->email = $request->input('email');
	    $user->password = Hash::make($request->input('password'));
	    $user->organization = $request->input('organization');
	    $user->save();

	    Auth::login($user);

	    return redirect('index');
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
