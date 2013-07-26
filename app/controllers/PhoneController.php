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


}