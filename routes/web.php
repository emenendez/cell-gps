<?php

use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;

// Prompt subject for location
Route::get('{phone?}', [PhoneController::class, 'index'])->name('phones.index');

Route::fallback(function () {
    Route::get('/');
});
