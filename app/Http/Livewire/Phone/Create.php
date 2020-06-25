<?php

namespace App\Http\Livewire\Phone;

use App\Models\Message;
use App\Models\Phone;
use Exception;
use Livewire\Component;
use Twilio\Rest\Client;

class Create extends Component
{
    public $number;

    public $message;

    public function save()
    {
        $validatedData = $this->validate([
            'number'  => ['required', 'phone:US'],
            'message' => ['nullable', 'string', 'max:100'],
        ]);

        $phone         = new Phone;
        $phone->number = $this->number;

        $phone->user()->associate(auth()->user());

        $phone->save();

        if (empty($this->message)) {
            $this->message = 'Tap link to send location to SAR: ';
        }

        $this->message = trim($this->message) . ' ' . route('phones.show', $phone);

        $message          = new Message;
        $message->message = $this->message;

        $phone->messages()->save($message);

        try {
            $client = new Client(config('services.twilio.account_sid'), config('services.twilio.auth_token'));

            $client->messages->create(
                $phone->number,
                [
                    'from' => config('services.twilio.number'),
                    'body' => $this->message,
                ]
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            session()->flash('error', 'Could not send SMS.');

            return redirect()->route('manage.dashboard');
        }

        // reset the form
        $this->message = '';
        $this->number  = '';

        $this->emit('phoneAdded');
    }

    public function render()
    {
        return view('livewire.phone.create');
    }
}
