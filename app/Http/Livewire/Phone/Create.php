<?php

namespace App\Http\Livewire\Phone;

use App\Models\Phone;
use Exception;
use Livewire\Component;
use Twilio\Rest\Client;

class Create extends Component
{
    public $number;

    public function save()
    {
        $validatedData = $this->validate([
            'number' => ['required', 'phone:US'],
        ]);

        $phone         = new Phone;
        $phone->number = $this->number;

        $phone->user()->associate(auth()->user());

        $phone->save();

        try {
            $client = new Client(config('services.twilio.account_sid'), config('services.twilio.auth_token'));

            $client->messages->create(
                $phone->number,
                [
                    'from' => config('services.twilio.number'),
                    'body' => 'Tap link to send location to SAR: ' . route('phones.show', $phone),
                ]
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            session()->flash('error', 'Could not send SMS.');

            return redirect()->route('manage.dashboard');
        }

        $this->emit('phoneAdded');
    }

    public function render()
    {
        return view('livewire.phone.create');
    }
}
