<?php

class Location extends Eloquent {

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
		return $this->belongsTo('Phone');
	}
	
}
