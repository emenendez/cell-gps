<?php

namespace App\Http\Livewire\Location;

use App\Models\Phone;
use Livewire\Component;

class Table extends Component
{
    public $phone;

    public function mount(Phone $phone)
    {
        $this->phone = $phone;
    }

    public function render()
    {
        return view('livewire.location.table');
    }
}
