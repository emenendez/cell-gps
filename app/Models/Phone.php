<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use libphonenumber\PhoneNumberUtil;

class Phone extends Model
{

	protected $touches = ['user'];

	protected $appends = ['token', 'number_pretty', 'last_location'];


	// RELATIONSHIPS

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function locations()
    {
		return $this->hasMany(Location::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function user()
    {
		return $this->belongsTo(User::class);
	}


	// ACCESSORS

	public function getLastLocationAttribute()
    {
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

	public function getNumberPrettyAttribute()
    {
		$number = $this->format($this->attributes['number']);
        if (is_null($number)) {
            return $this->user_agent;
        } else {
            return $number;
        }
	}

	public function getTokenAttribute()
    {
		return base64url_encode($this->attributes['id']);
	}


	// MUTATORS


	public function setNumberAttribute($value)
    {
		$this->attributes['number'] = $this->format($value, PhoneNumberFormat::E164);
	}


	// SCOPES

    public function scopeNumber($query, $number)
    {
        return $query->whereNumber($this->format($number, PhoneNumberFormat::E164));
    }


    // HELPERS

    /**
     * @param $number
     * @param null $format
     * @return string|null
     * @throws \libphonenumber\NumberParseException
     */
	private function format($number, $format = null)
    {
        if (!is_null($number)) {
    		$phoneUtil = PhoneNumberUtil::getInstance();

        	$phoneProto = $phoneUtil->parse($number, config('app.region'));

        	if (!is_null($format)) {
        		return $phoneUtil->format($phoneProto, $format);
        	} else {
        		if ($phoneUtil->getRegionCodeForNumber($phoneProto) == config('app.region')) {
        			return $phoneUtil->format($phoneProto, PhoneNumberFormat::NATIONAL);
        		} else {
        			return $phoneUtil->format($phoneProto, PhoneNumberFormat::INTERNATIONAL);
        		}
        	}
        } else {
            return null;
        }
	}
}
