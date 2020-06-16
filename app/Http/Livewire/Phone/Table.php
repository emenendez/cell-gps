<?php

namespace App\Http\Livewire\Phone;

use Livewire\Component;

class Table extends Component
{

    public $phones;

    protected $listeners = ['phoneAdded' => 'phoneAdded'];

    public function phoneAdded()
    {
        $this->phones = auth()->user()->phones()->orderBy('updated_at', 'desc')->get();
    }

    public function mount()
    {
        $this->phones = auth()->user()->phones()->orderBy('updated_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.phone.table');
    }
}
