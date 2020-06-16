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
    public function index()
    {
        if (!session()->has('phone')) {
            $phone             = new Phone;
            $phone->ip         = request()->ip();
            $phone->user_agent = request()->header('User-Agent');

            if (!$phone->save()) {
                logger()->warning('could not create a phone', ['line' => __LINE__, 'file' => __FILE__]);

                return redirect()->route('help')->withError('Could not generate a new record.');
            }

            session(['phone' => $phone->token]);
        }

        return redirect()->route('phones.show', session('phone'));
    }

    public function show(Phone $phone)
    {
        // first visit
        if (!session()->has('phone') && $phone->locations()->count() === 0) {
            $phone->ip         = request()->ip();
            $phone->user_agent = request()->header('User-Agent');
            $phone->save();

            session(['phone' => $phone->token]);
        }

        // session / url mismatch
        if (session('phone') !== $phone->token) {
            session()->forget('phone');

            return redirect()->route('home');
        }

        return view('site.phones.show', compact('phone'));
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
}
