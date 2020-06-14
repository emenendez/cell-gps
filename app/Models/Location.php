<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public $dates = [
        'location_time',
    ];


    // RELATIONSHIPS

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function phone() {
		return $this->belongsTo(Phone::class);
	}


	// MUTATORS

    public function setAccuracyAttribute($value)
    {
        $this->attributes['accuracy'] = $this->clean($value);
    }

    public function setAltitudeAttribute($value)
    {
        $this->attributes['altitude'] = $this->clean($value);
    }

    public function setAltitudeAccuracyAttribute($value)
    {
        $this->attributes['altitude_accuracy'] = $this->clean($value);
    }

    public function setHeadingAttribute($value)
    {
        $this->attributes['heading'] = $this->clean($value);
    }

    public function setSpeedAttribute($value)
    {
        $this->attributes['speed'] = $this->clean($value);
    }


    // HELPERS

    /**
     * Convert from 'null or NULL to float
     *
     * @param $value
     * @return float|null
     */
    private function clean($value)
    {
        // convert string to actual
        if ($value === 'null') {
            $value = null;
        }

        // convert to float
//        if (!is_null($value)) {
//            $value = floatval($value);
//        }

        return $value;
    }
}
