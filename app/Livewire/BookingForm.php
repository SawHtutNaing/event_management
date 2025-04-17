<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Booking;

class BookingForm extends Component
{
    public $event;
    public $tickets = 1;
    public $totalPrice;
    public $bookingSuccess = false;
    public $is_still_available ;
    public function mount(Event $event)
    {
        $this->event = $event;
        $this->is_still_available = $this->event->availableSeat() > 0 ;




    }


    public function bookEvent()
    {


        Booking::create([
            'user_id' => auth()->id(),
            'event_id' => $this->event->id,

        ]);

        $this->event->capacity = $this->event->capacity  - 1 ;
        $this->event->update();


        $this->bookingSuccess = true;
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
