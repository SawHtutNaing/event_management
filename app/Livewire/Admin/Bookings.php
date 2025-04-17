<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class Bookings extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;

    protected $queryString = ['startDate', 'endDate'];

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
        $query = Booking::query();


        if ($this->startDate && $this->endDate) {
            $query->whereHas('event', function ($q) {
                $q->where(function ($q2) {
                    $q2->where(function ($sub) {
                        $sub->whereDate('start_date', '<=', $this->endDate)
                            ->whereDate('end_date', '>=', $this->startDate);
                    });
                });
            });
        } elseif ($this->startDate) {
            $query->whereHas('event', function ($q) {
                $q->whereDate('end_date', '>=', $this->startDate);
            });
        } elseif ($this->endDate) {
            $query->whereHas('event', function ($q) {
                $q->whereDate('start_date', '<=', $this->endDate);
            });
        }

        $bookings = $query->paginate(20);


        return view('livewire.admin.bookings', compact('bookings'));
    }

    public function goEventDetails(Event $event)
    {
        return redirect()->route('events.show', $event->id);
    }
}

