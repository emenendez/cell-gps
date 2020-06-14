<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $touches = ['phone'];

    /**
     * @todo cthompson: this needs updated
     */
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


    // RELATIONSHIPS

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function phone() {
		return $this->belongsTo(Phone::class);
	}
}
