<?php

use Carbon\Carbon;

class PhoneController extends \BaseController {

  /**
   * Purge old phones from database
   */
  private function purgePhones()
  {
  	// Delete all phones without activity within the past week
    Phone::where('updated_at', '<', Carbon::now()->subWeek())->delete();
  	// Delete all Guest phones without activity within the past day
  	Phone::where('user_id', '1')->where('updated_at', '<', Carbon::now()->subDay())->delete();
  }
  
  /**
   * Show all phones for the logged-in user
   */
  public function showPhones()
  {
    $this->purgePhones();

    $phones = Phone::where('user_id', Auth::user()->id)
      ->orWhere('user_id', 1)
      ->orderBy('created_at', 'desc')
      ->orderBy('id', 'desc')
      ->get();

    foreach($phones as $phone) {
    	$phone->location = $phone->locations()->orderBy('created_at', 'desc')->first();
    	if(!$phone->location) {
    		$phone->location = new Location;
        $phone->location->location = '';
        $phone->location->accuracy = '';
        $phone->location->altitude = '';
        $phone->location->altitudeAccuracy = '';
        $phone->location->heading = '';
        $phone->location->speed = '';
        $phone->location->location_time = '';
        $phone->location->created_at = '';
    	}
    }
    return View::make('phones', array('phones' => $phones, 'success' => Session::get('success')));
  }

  /**
   * Show all locations for given phone
   * Verify phone belongs to user or guest
   */
  public function showPhone(Phone $phone)
  {
  	if( !($phone->user->id == Auth::user()->id || $phone->user->id == 1) ) {
  		App::abort(401, 'You are not authorized.');
  	}

  	$locations = $phone->locations()->orderBy('created_at', 'desc')->get();

  	return View::make('phone', array('email' => $phone->email, 'phone_time' => $phone->created_at, 'locations' => $locations));
  }

  /**
   * Send SMS message
   */
  public function sendSMS()
  {
  	// Make input available in future requests
  	Input::flash();

  	// Validate input
	  $validator = Validator::make(
			Input::all(), 
			array(
				'phone' => array('required', 'regex:/1?[\d]{3}[\D]*[\d]{3}[\D]*[\d]{4}/'),
				'gateway' => array('required', 'regex:/([[:alnum:]\-]+\.)+[[:alnum:]\-]+/')
				),
			array(
				'phone.regex' => 'The phone field must be a valid 10-digit phone number.',
				'gateway.regex' => 'The gateway field must be a valid domain.'
				));

	  if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator);
    }

    // Apply phone regex to input and build email address
    $matches = array();
    preg_match('/1?([\d]{3})[\D]*([\d]{3})[\D]*([\d]{4})/', Input::get('phone'), $matches);
    $email = $matches[1] . $matches[2] . $matches[3] . '@' . Input::get('gateway');

    $subject = Input::get('subject');
    if ($subject == '') {
      $subject = 'Tap link to send location to SAR';
    }

  	// Add phone to database
  	$phone = new Phone;
  	$phone->email = $email;
  	$phone = Auth::user()->phones()->save($phone);

		// Get token
		$token = base64url_encode($phone->id);

    // Send email with token
		Mail::send(array('text' => 'emails.sms'), array('token' => $token, 'body' => Input::get('message')), function($message) use ($email, $subject) {
			$message->to($email)->subject($subject);
    });

		return Redirect::route('index')->with('success', 'Email sent to ' . $email);
	}

  /**
   * Parse token and return phone model
   * Create a new phone if need be
   */
  private function getPhone($token)
  {
    // Base64url-decode ID
    $id = (int) base64url_decode($token);
    $phone = Phone::find($id);

    if(!$phone)
    {
      // Use IP address to generate ID
      $userString = $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'];
      $phone = new Phone;
      $phone->user_id = 1;
      $phone->email = $userString;
      $phone->created_at = Carbon::now();
      $phone->save();
    }

    return $phone;
  }

  /**
   * Prompt subject device for location
   */
  public function getLocation($token = null)
  {
    $phone = $this->getPhone($token);
    return View::make('subject', array('token' => base64url_encode($phone->id)));
  }

  /**
   * Get location from subject device
   */
  public function setLocation($token, $loc, $altitude, $accuracy, $altitudeAccuracy, $heading, $speed, $location_time)
  {
    // This route is called via AJAX
    // Update database with location using ID
    // Return a confirmation to user
    
    // Register catch-all error handler, just for this request
    App::error(function(Exception $exception, $code)
    {
      echo('Error: <a href="./">Location not received. Tap here to reload page.</a>');
    });
    
    $phone = $this->getPhone($token);
    $location = new Location;

    $location->location = $loc;
    $location->altitude = $altitude;
    $location->accuracy = $accuracy;
    $location->altitudeAccuracy = $altitudeAccuracy;
    $location->heading = $heading;
    $location->speed = $speed;
    $location->location_time = $location_time / 1000;

    $phone->locations()->save($location);

    echo('Your location has been received by Search &amp; Rescue.');
  }

}