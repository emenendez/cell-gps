<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function () {
    Route::get('update/{phone}/{longitude}/{latitude}/{altitude}/{accuracy}/{altitudeAccuracy}/{heading}/{speed}/{location_time}', [PhoneController::class, 'update'])->name('phones.update');
});
