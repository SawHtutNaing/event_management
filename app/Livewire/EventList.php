<?php


namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventList extends Component
{
    public $search;
    public $startDate;
    public $endDate;

    public function render()
    {
        $start = $this->startDate;
        $end = $this->endDate;

        $events = Event::query()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->where(function ($query) use ($start, $end) {
                    $query->where('start_date', '<=', $end)
                          ->where('end_date', '>=', $start);
                });
            })
            ->when($start && !$end, function ($q) use ($start) {
                $q->where('end_date', '>=', $start);
            })
            ->when(!$start && $end, function ($q) use ($end) {
                $q->where('start_date', '<=', $end);
            })
            ->paginate(10);

        return view('livewire.event-list', compact('events'));
    }
}
