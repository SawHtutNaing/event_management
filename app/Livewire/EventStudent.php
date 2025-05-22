<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;


class EventStudent extends Component
{

    public $event;
    public $students = [];
    public function mount( Event $event)
    {
        $this->event = $event;
        $this->students = $this->event->students()->get();
    }


    public function render()
    {
        return view('livewire.event-student');
    }
}
