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
        }
        return View::make('phones', array('phones' => $phones));
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
	        return Redirect::to('/')->withErrors($validator);
	    }

	    /*

		$email = Input::get('phone') . '@' . Input::get('gateway');

    	// Add email to database and get ID
		// Send email with ID
		if(!$db->query("insert into phones (email) values ('" . $db->escape_string($email) . "')") || $db->insert_id == 0)
		{
			// Error
			echo('<div id="error">SMS email could not be inserted into database.</div>');
		}
		else
		{
			$id = base64url_encode($db->insert_id);
			if(!mail($email, $_POST['subject'], $BASE_URL . $id . ' ' . $_POST['message'], 'From: ASRC <gps@asrc.net>'))
			{
				// Error
				echo('<div id="error">Could not send email.</div>');
			}
		}	
	    */
	}

}