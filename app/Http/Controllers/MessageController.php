<?php

class MessageController extends \Controller {

  /**
   * Send SMS message
   */
  public function send()
  {
  	// Make input available in future requests
  	Input::flash();

  	// Validate input
	  $validator = Validator::make(
			Input::all(), 
			array(
				'phone' => array('required', 'phone:US'),
				));

	  if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator);
    }

    // Use default message if user left it blank
    $copy = Input::get('message');
    if (trim($copy) == '') {
      $copy = 'Tap link to send location to SAR:';
    }

    // Try to see if phone already exists
    $phone = Auth::user()->phones()->number(Input::get('phone'))->first();

    if (!$phone)
    {
    	// Add phone to database
    	$phone = new Phone;
    	$phone->number = Input::get('phone');
    	$phone = Auth::user()->phones()->save($phone);
    }

    // Create message
    $message = new Message;
    $message->message = sprintf('%s %s/%s', $copy, route('get-location'), $phone->token);
    $phone->messages()->save($message);

    // Send message
    $message->send();

		return Redirect::route('index')->with('success', 'SMS sent to ' . $phone->number_pretty);
	}

}