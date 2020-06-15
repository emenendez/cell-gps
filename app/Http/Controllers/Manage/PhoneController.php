<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Phone;

class PhoneController extends Controller
{

    public function show(Phone $phone)
    {
        abort_unless($phone->user_id === auth()->id(), 403);

        return view('manage.phones.show', compact('phone'));
    }

}
