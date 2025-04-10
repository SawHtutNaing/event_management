<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventList extends Component
{

    public $search ;

    public function render()
    {

        $events = Event::
        when($this->search , function($q){
            return $q->where('title', 'like', '%' . $this->search . '%');

        })
        ->
        paginate(10);
        return view('livewire.event-list' , compact('events'));
    }
}
