<?php

use App\Http\Controllers\PhoneController;
use App\Http\Controllers\Manage\PhoneController as ManagePhoneController;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Prompt subject for location
Route::get('/', [PhoneController::class, 'index'])->name('home');

Route::fallback(function () {
    Route::get('/');
});

Route::view('help', 'site.help')->name('help');

Route::group(['middleware' => 'auth'], function () {
    Route::view('dashboard', 'manage.dashboard')->name('manage.dashboard');

    Route::get('manage/{phone}', [ManagePhoneController::class, 'show'])->name('manage.phones.show');
});

Route::view('help', 'site.help')->name('help');

// sweeper
Route::get('{phone}', [PhoneController::class, 'show'])->name('phones.show');
