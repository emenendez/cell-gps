<?php

class MessageController extends \Controller {

  /**
   * Send SMS message
   */
  public function store(Request $request)
  {
  	// Validate input
    $this->validate($request, [
			'phone' => array('required', 'phone:US'),
		]);

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

    return response()->json(['success' => true]);
	}

}