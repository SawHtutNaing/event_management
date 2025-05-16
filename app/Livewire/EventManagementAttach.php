<?php
namespace App\Livewire;

use App\Models\Batch;
use App\Models\Event;
use Livewire\Component;

class EventManagementAttach extends Component
{
    public $events;
    public $batches;

    public $selectedEvent = null;
    public $selectedBatch = null;

    public function mount()
    {
        $this->events = Event::all();
        $this->batches = Batch::all();
    }

    public function selectEvent($eventId)
    {
        $this->selectedEvent = Event::with('batches')->find($eventId);
    }

    public function attachBatchToEvent()
    {
        if ($this->selectedEvent && $this->selectedBatch) {
            $this->selectedEvent->batches()->syncWithoutDetaching([$this->selectedBatch]);
            $this->selectedEvent = $this->selectedEvent->fresh(); // refresh relation
            $this->selectedBatch = null;
        }
    }

    public function detachBatchFromEvent($batchId)
    {
        if ($this->selectedEvent) {
            $this->selectedEvent->batches()->detach($batchId);
            $this->selectedEvent = $this->selectedEvent->fresh(); // refresh
        }
    }

    public function render()
    {
        return view('livewire.event-management-attach');
    }
}
