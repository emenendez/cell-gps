<?php

class PhoneController extends BaseController {

    /**
     * Show all phones for the logged-in user
     */
    public function showPhones()
    {
        $phones = Phone::where('user_id', Auth::user()->id)
          ->orWhere('user_id', 1)
          ->orderBy('created_at', 'desc')
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
    	if( !($phone->user() == Auth::user() || $phone->user->id == 1) ) {
    		throw new NotFoundException;
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
		// Get ID
		$id = base64url_encode($phone->id);
		// Send email with ID
		Mail::send(array('text' => 'emails.sms'), array('id' => $id, 'body' => Input::get('message')), function($message) use ($email, $subject) {
			$message->to($email)->subject($subject);
		});

		return Redirect::route('index')->with('success', 'Email sent to ' . $email);
	}

}