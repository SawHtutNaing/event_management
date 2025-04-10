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

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalPrice = $this->tickets * $this->event->price;
    }

    public function bookEvent()
    {
        $this->validate([
            'tickets' => ['required', 'integer', 'min:1', 'max:' . $this->event->availableTickets()]
        ]);

        Booking::create([
            'user_id' => auth()->id(),
            'event_id' => $this->event->id,
            'tickets' => $this->tickets,
            'total_price' => $this->totalPrice,
            'status' => 'confirmed'
        ]);

        $this->bookingSuccess = true;
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}