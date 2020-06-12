<?php

namespace App;

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
}
