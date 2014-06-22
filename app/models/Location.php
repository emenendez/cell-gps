<?php

class Location extends Eloquent {

	public function phone() {
		return $this->belongsTo('Phone');
	}
	
}
