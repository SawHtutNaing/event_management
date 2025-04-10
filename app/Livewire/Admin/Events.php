<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;
use App\Livewire\ConfirmationModal;
class Events extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'start_date';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $showDeleteModal = false;
    public $eventIdToDelete;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // public function confirmDelete($eventId)
    // {
        
    //     $this->dispatch('confirmDelete', eventId: $eventId)->to(ConfirmationModal::class);
    // }

    public function deleteEvent($eventId)
    {
        Event::find($eventId)->delete();
        session()->flash('message', 'Event deleted successfully.');
    }


    public function approveEvent($eventId)
    {
        $event = Event::find($eventId);
        $event->update(['is_approved' => true]);
        session()->flash('message', 'Event approved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.events', [
            'events' => Event::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('location', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }
}