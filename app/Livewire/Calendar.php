<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Calendar extends Component
{
    public $currentDate;
    public $events = [];
    public $showEventModal = false;
    public $selectedEvent = null;
    public $view = 'month'; // month, week, day

    public function mount()
    {
        $this->currentDate = now();
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();

        $this->events = Event::whereBetween('start_date', [$startOfMonth, $endOfMonth])
            ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
            ->get();
    }

    public function previousPeriod()
    {
        if ($this->view === 'month') {
            $this->currentDate->subMonth();
        } elseif ($this->view === 'week') {
            $this->currentDate->subWeek();
        } else {
            $this->currentDate->subDay();
        }
        $this->loadEvents();
    }

    public function nextPeriod()
    {
        if ($this->view === 'month') {
            $this->currentDate->addMonth();
        } elseif ($this->view === 'week') {
            $this->currentDate->addWeek();
        } else {
            $this->currentDate->addDay();
        }
        $this->loadEvents();
    }

    public function goToToday()
    {
        $this->currentDate = now();
        $this->loadEvents();
    }

    public function changeView($view)
    {
        $this->view = $view;
    }

    public function showEvent($eventId)
    {
        $this->selectedEvent = Event::find($eventId);
        $this->showEventModal = true;
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}