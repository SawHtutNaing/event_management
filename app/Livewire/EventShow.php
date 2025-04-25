<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventShow extends Component
{



    public $event;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $capacity;
    // public $price;
    public $image;
    public $is_approved = false;
    public $existingImage;




    public function mount( $event){
        if ($event) {

            $this->event = Event::findOrFail($event);
            $this->title = $this->event->title;
            $this->description = $this->event->description;
            $this->start_date = $this->event->start_date->format('Y-m-d\TH:i');
            $this->end_date = $this->event->end_date->format('Y-m-d\TH:i');
            $this->location = $this->event->location;
            $this->capacity = $this->event->capacity;
            // $this->price = $this->event->price;
            $this->is_approved = $this->event->is_approved;
            $this->existingImage = $this->event->image;
        }


    }


    public function render()
    {
        return view('livewire.event-show');
    }
}
