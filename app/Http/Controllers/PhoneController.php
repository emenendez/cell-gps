<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Phone;
use App\Models\User;

class PhoneController extends Controller
{

    /**
     * Prompt subject device for location
     */
    public function index(Phone $phone = null)
    {
        // phone was created, but doesn't match current route
        if (url()->current() !== route('phones.index', $phone)) {
            return redirect()->route('phones.index', $phone);
        }

        // Update the user agent
        $phone->user_agent = request()->ip() . ' ' . request()->header('User-Agent');

        $phone->save();

        return view('site.index', compact('phone'));
    }

    /**
     * Get location from subject device
     */
    public function update(Phone $phone, $longitude, $latitude, $altitude, $accuracy, $altitudeAccuracy, $heading, $speed, $location_time)
    {
        $location                    = new Location;
        $location->latitude          = $latitude;
        $location->longitude         = $longitude;
        $location->altitude          = $altitude;
        $location->accuracy          = $accuracy;
        $location->altitude_accuracy = $altitudeAccuracy;
        $location->heading           = $heading;
        $location->speed             = $speed;
        $location->location_time     = intval($location_time) / 1000;

        $location->phone()->associate($phone);

        $location->save();

        return 'Your location has been received by Search &amp; Rescue.';
    }






    /**
     * Purge old phones from database
     *
     * @todo: cthompson move to Artisan command/schedule
     */
    private function purgePhones()
    {
        // Delete all phones without activity within the past week
        Phone::where('updated_at', '<', now()->subWeek())->delete();

        // Delete all Guest phones without activity within the past day
        User::Guest()->phones()->where('updated_at', '<', Carbon::now()->subDay())->delete();
    }

    /**
     * Show all phones for the logged-in user
     */
    public function showPhones()
    {
        $this->purgePhones();

        $phones = Phone::where('user_id', Auth::user()->id)
            ->orWhere('user_id', User::guestId())
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return View::make('phones', array('phones' => $phones, 'success' => Session::get('success')));
    }

    /**
     * Show all locations for given phone
     * Verify phone belongs to user or guest
     */
    public function showPhone(Phone $phone)
    {
        if( !($phone->user->id == Auth::user()->id || $phone->user->id == User::guestId()) ) {
            App::abort(401, 'You are not authorized.');
        }

        return View::make('phone', array('phone' => $phone));
    }

    /**
     * Parse token and return phone model
     * Create a new phone if need be
     */
    private function getPhone ($token)
    {
        // Base64url-decode ID
        $id = (int) base64_decode(str_pad(strtr($token, '-_', '+/'), strlen($token) % 4, '=', STR_PAD_RIGHT));
        $phone = Phone::find($id);

        if(!$phone) {
            // Create a new phone with no number
            $phone = new Phone;
            $phone->user_id = User::guestId();
        }

        // Update the user agent
        $phone->user_agent = request()->ip() . ' ' . request()->header('User-Agent');

        $phone->save();

        return $phone;
    }

    /**
     * Convert 'null' to null, all other values to float
     */
    private function toFloat($input)
    {
        if (is_null($input))
        {
            return null;
        }
        else if (strtolower($input) == 'null')
        {
            return null;
        }
        else
        {
            return floatval($input);
        }
    }

}
