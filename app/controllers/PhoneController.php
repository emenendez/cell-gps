<?php

class PhoneController extends BaseController {

    /**
     * Show all phones for the logged-in user
     */
    public function showPhones()
    {
        $phones = Phone::where('user_id', Auth::user()->id)
          ->orWhere('user_id', 1)
          ->orderBy('created_at', 'desc')
          ->get();

        foreach($phones as $phone) {
        	$phone->location = $phone->locations()->orderBy('created_at', 'desc')->first();
        }

        return View::make('phones', array('phones' => $phones));
    }

    /**
     * Show all locations for given phone
     * Verify phone belongs to user or guest
     */
    public function showPhone(Phone $phone)
    {
    	if( !($phone->user() == Auth::user() || $phone->user->id == 1) ) {
    		throw new NotFoundException;
    	}

    	$locations = $phone->locations()->orderBy('created_at', 'desc')->get();

    	return View::make('phone', array('email' => $phone->email, 'phone_time' => $phone->created_at, 'locations' => $locations));
    }

}