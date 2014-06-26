<?php

class Location extends Eloquent {

	protected $touches = array('phone');

	public function phone() {
		return $this->belongsTo('Phone');
	}
	
}
