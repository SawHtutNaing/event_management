<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class UserBookingIndex extends Component
{
    use WithPagination;

    public $user;
    public $startDate;
    public $endDate;

    protected $queryString = ['startDate', 'endDate'];

    public function mount()
    {
        $this->user = User::find(auth()->id());
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {

        $query = $this->user->bookings()->with('event');

        if ($this->startDate && $this->endDate) {
            $start = $this->startDate;
            $end = $this->endDate;

            $query->whereHas('event', function ($q) use ($start, $end) {
                $q->where(function ($q2) use ($start, $end) {
                    $q2->where(function ($sub) use ($start, $end) {
                        $sub->whereDate('start_date', '<=', $end)
                            ->whereDate('end_date', '>=', $start);
                    });
                });
            });
        } elseif ($this->startDate) {
            $start = $this->startDate;

            $query->whereHas('event', function ($q) use ($start) {
                $q->whereDate('end_date', '>=', $start);
            });
        } elseif ($this->endDate) {
            $end = $this->endDate;

            $query->whereHas('event', function ($q) use ($end) {
                $q->whereDate('start_date', '<=', $end);
            });
        }




        $bookings = $query->paginate(10);

        return view('livewire.user-booking-index', compact('bookings'));
    }

    public function goEventDetails(Event $event)
    {
        return redirect()->route('events.show', $event->id);
    }
}
