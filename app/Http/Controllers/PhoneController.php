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

            return redirect()->route('phones.show', $phone);
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

}
