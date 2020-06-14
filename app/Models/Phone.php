<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use libphonenumber\PhoneNumberUtil;

class Phone extends Model
{

    public static function boot()
    {
        parent::boot();

        static::saving(function ($phone) {
            if (empty($phone->ip)) {
                $phone->ip = request()->ip();
            }

            if (empty($phone->user_agent)) {
                $phone->user_agent = request()->header('User-Agent');
            }
        });

        static::saved(function ($phone) {
            if (empty($phone->token)) {
                $phone->token      = rtrim(strtr(base64_encode($phone->id), '+/', '-_'), '=');
                $phone->timestamps = false;
                $phone->save();
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if (is_null($value)) {
            return $value;
        }

        if (!($phone = $this->where($this->getRouteKeyName(), $value)->first())) {
            // Create a new phone with no number
            $phone = new Phone;

            $phone->save();
        }

        return $phone;
    }


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

//	public function getTokenAttribute()
//    {
//		return rtrim(strtr(base64_encode($this->attributes['id']), '+/', '-_'), '=');
//	}


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
