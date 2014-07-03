<?php

class Phone extends Eloquent {

	protected $touches = array('user');

	protected $appends = array('token', 'number_pretty');

	private function format($number, $format = null) {
		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    	$phoneProto = $phoneUtil->parse($number, Config::get('app.region'));
    	if ($format == null)
    	{
    		return $phoneUtil->format($phoneProto, $format);
    	}
    	else
    	{
    		if ($phoneUtil->getRegionCodeForNumber($phoneProto) == Config::get('app.region'))
    		{
    			return $phoneUtil->format($phoneProto, \libphonenumber\PhoneNumberFormat::NATIONAL);
    		}
    		else
    		{
    			return $phoneUtil->format($phoneProto, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);    			
    		}
    	}
	}

	public function getTokenAttribute() {
		return base64url_encode($this->attributes['id']);
	}

	public function getNumberPrettyAttribute() {
		return $this->format($this->attributes['number']);
	}

	public function setNumberAttribute($value) {
		$this->attributes['number'] = $this->format($value, \libphonenumber\PhoneNumberFormat::E164);
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function locations() {
		return $this->hasMany('Location');
	}

}
