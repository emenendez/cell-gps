<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Vinkla\Hashids\Facades\Hashids;

class Phone extends Model
{

    public static function boot()
    {
        parent::boot();

        static::saved(function ($phone) {
            if (empty($phone->token)) {
                $hash = null;

                if (!is_int($phone->getKey())) {
                    logger()->error('can only hash integers');

                    return;
                }

                try {
                    $hash = Hashids::connection(self::class);
                } catch (Exception $e) {
                    logger()->error($e->getMessage());
                }

                if ($hash) {
                    $phone->token      = $hash->encode($phone->getKey());
                    $phone->timestamps = false;
                    $phone->save();
                }
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
