<?php

class Phone extends Eloquent {

	protected $touches = array('user');

	public function user() {
		return $this->belongsTo('User');
	}

	public function locations() {
		return $this->hasMany('Location');
	}

}
