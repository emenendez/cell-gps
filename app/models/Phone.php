<?php

class Phone extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function locations() {
		return $this->hasMany('Location');
	}

}
