<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Phone;
use App\User;
use App\Location;
use Auth;

class PhoneController extends Controller {

  /**
   * Purge old phones from database
   */
  private function purgePhones()
  {
  	// Delete all phones without activity within the past week
    Phone::where('updated_at', '<', Carbon::now()->subWeek())->delete();
  	// Delete all Guest phones without activity within the past day
    User::Guest()->phones()->where('updated_at', '<', Carbon::now()->subDay())->delete();
  }
  
  /**
   * Return all phones for the logged-in user
   *
   * @return Response
   */
  public function index()
  {
    $this->purgePhones();

    return Phone::where('user_id', Auth::user()->id)
      ->orWhere('user_id', User::guestId())
      ->orderBy('created_at', 'desc')
      ->orderBy('id', 'desc')
      ->get();
  }

  /**
   * Show all locations for given phone
   * Verify phone belongs to user or guest
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $phone = Phone::find($id);

    if( !($phone->user->id == Auth::user()->id || $phone->user->id == User::guestId()) ) {
      App::abort(401, 'You are not authorized.');
    }

    return $phone->locations()->get();
  }

  /**
   * Parse token and return phone model
   * Create a new phone if need be
   */
  private function getPhone($token)
  {
    // Base64url-decode ID
    $id = (int) base64url_decode($token);
    $phone = Phone::find($id);

    if(!$phone)
    {
      // Create a new phone with no number
      $phone = new Phone;
      $phone->user_id = User::guestId();
    }

    // Update the user agent
    $phone->user_agent = $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'];
    $phone->save();

    return $phone;
  }

  /**
   * Prompt subject device for location
   */
  public function getLocation($token = null)
  {
    $phone = $this->getPhone($token);
    return view('subject', ['token' => $phone->token]);
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

  /**
   * Get location from subject device
   */
  public function setLocation($token, $longitude, $latitude, $altitude, $accuracy, $altitudeAccuracy, $heading, $speed, $location_time)
  {
    // This route is called via AJAX
    // Update database with location using ID
    // Return a confirmation to user
    
    try {
      $phone = $this->getPhone($token);
      $location = new Location;

      $location->location = sprintf('(%s, %s)', $latitude, $longitude);
      $location->altitude = $this->toFloat($altitude);
      $location->accuracy = $this->toFloat($accuracy);
      $location->altitudeAccuracy = $this->toFloat($altitudeAccuracy);
      $location->heading = $this->toFloat($heading);
      $location->speed = $this->toFloat($speed);
      $location->location_time = intval($location_time) / 1000;

      $phone->locations()->save($location);

      echo('Your location has been received by Search &amp; Rescue.');
    }
    catch (Exception $e) {
      echo('Error: <a href="./">Location not received. Tap here to reload page.</a>');
    }
  }



  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

}