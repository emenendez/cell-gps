<?php

class Message extends Eloquent {

	protected $touches = array('phone');

    public function send()
    {
        // Send SMS with token using Twilio
        $twilio = new Services_Twilio($_ENV['TWILIO_ACCOUNT_SID'], $_ENV['TWILIO_AUTH_TOKEN']);
        $sms = $twilio->account->messages->sendMessage(
          $_ENV['TWILIO_NUMBER'], 
          $this->phone->number,
          $this->message
        );
        // Update timestamp
        $this->touch();
    }

	public function phone() {
		return $this->belongsTo('Phone');
	}

}
