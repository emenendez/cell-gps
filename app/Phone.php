<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {

	protected $touches = array('user');

	protected $appends = array('token', 'number_pretty', 'last_location');

	private function format($number, $format = null) {
        if (!is_null($number))
        {
    		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        	$phoneProto = $phoneUtil->parse($number, config('app.region'));
        	if (!is_null($format))
        	{
        		return $phoneUtil->format($phoneProto, $format);
        	}
        	else
        	{
        		if ($phoneUtil->getRegionCodeForNumber($phoneProto) == config('app.region'))
        		{
        			return $phoneUtil->format($phoneProto, \libphonenumber\PhoneNumberFormat::NATIONAL);
        		}
        		else
        		{
        			return $phoneUtil->format($phoneProto, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);    			
        		}
        	}
        }
        else
        {
            return null;
        }
	}

	public function getTokenAttribute() {
		return base64url_encode($this->attributes['id']);
	}

	public function getNumberPrettyAttribute() {
		$number = $this->format($this->attributes['number']);
        if (is_null($number))
        {
            return $this->user_agent;
        }
        else
        {
            return $number;
        }
	}

	public function setNumberAttribute($value) {
		$this->attributes['number'] = $this->format($value, \libphonenumber\PhoneNumberFormat::E164);
	}

    public function scopeNumber($query, $number)
    {
        return $query->whereNumber($this->format($number, \libphonenumber\PhoneNumberFormat::E164));
    }

	public function getLastLocationAttribute() {
		$location = $this->locations()->orderBy('created_at', 'desc')->first();
    	if(!$location) {
    		$location = new Location;
        	$location->location = '';
        	$location->accuracy = '';
        	$location->altitude = '';
        	$location->altitudeAccuracy = '';
        	$location->heading = '';
        	$location->speed = '';
        	$location->location_time = '';
        	$location->created_at = '';
    	}
    	return $location;
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function locations() {
		return $this->hasMany('Location');
	}

    public function messages() {
        return $this->hasMany('Message');
    }

}
