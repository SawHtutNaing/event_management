<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class EventForm extends Component
{
    use WithFileUploads;

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

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        // 'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'is_approved' => 'boolean'
    ];

    public function mount($event = null)
    {

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

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'capacity' => $this->capacity,
            // 'price' => $this->price,
            'is_approved' => $this->is_approved,
            'user_id' => auth()->id()
        ];

        if ($this->image) {
            $path = $this->image->store('events', 'public');
            $data['image'] = $path;
        }

        if ($this->event) {
            $this->event->update($data);
            session()->flash('message', 'Event updated successfully.');
        } else {
            Event::create($data);
            session()->flash('message', 'Event created successfully.');
        }

        return redirect()->route('admin.events.index');
    }

    public function render()
    {

        return view('livewire.admin.event-form');
    }
}
