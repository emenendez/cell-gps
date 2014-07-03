<?php

class Phone extends Eloquent {

	protected $touches = array('user');

	protected $appends = array('token');

	public function getTokenAttribute() {
		return base64url_encode($this->attributes['id']);
	}

	public function user() {
		return $this->belongsTo('User');
	}

	public function locations() {
		return $this->hasMany('Location');
	}

}
