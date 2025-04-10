<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmationModal extends Component
{
    public $show = false;
    public $title;
    public $content;
    public $eventId;

    protected $listeners = ['confirmDelete' => 'prepareDelete'];

    public function prepareDelete($eventId)
    {
        $this->show = true;
        $this->title = 'Delete Event';
        $this->content = 'Are you sure you want to delete this event? This action cannot be undone.';
        $this->eventId = $eventId;
    }

    public function delete()
    {
        $this->dispatch('performDelete', eventId: $this->eventId);
        $this->resetModal();
    }

    public function resetModal()
    {
        $this->reset(['show', 'title', 'content', 'eventId']);
    }

    public function render()
    {
        return view('livewire.confirmation-modal');
    }
}