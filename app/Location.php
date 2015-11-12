<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $touches = array('phone');

	/**
	 * Date fields
	 */
	public function getDates()
	{
		return array(
			'created_at',
			'updated_at',
			'location_time',
			);
	}

	public function phone() {
		return $this->belongsTo('App\Phone');
	}
	
}
