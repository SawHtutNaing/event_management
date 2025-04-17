<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Home extends Component
{

    public $events ;

    public function mount(){
        $this->events = Event::latest()->take(3)->get();

    }
    public function render()
    {
        return view('livewire.home')
        ->extends('components.layouts.noauth') // this is correct
        ->section('content'); // TH
    }
}
