<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\Role;
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
    public $image;
    public $is_approved = false;
    public $existingImage;
    public $selectedStudents = [];
    public $availableStudents = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'location' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'image' => 'nullable|image|max:2048',
        'is_approved' => 'boolean',
        'selectedStudents' => 'array',
        'selectedStudents.*' => 'exists:users,id'
    ];

    public function mount($event = null)
    {
        // Load all users with the 'student' role
        $this->availableStudents = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get()->map(function ($user) {
            return ['id' => $user->id, 'name' => $user->name];
        })->toArray();

        if ($event) {
            $this->event = Event::findOrFail($event);
            $this->title = $this->event->title;
            $this->description = $this->event->description;
            $this->start_date = $this->event->start_date->format('Y-m-d\TH:i');
            $this->end_date = $this->event->end_date->format('Y-m-d\TH:i');
            $this->location = $this->event->location;
            $this->capacity = $this->event->capacity;
            $this->is_approved = $this->event->is_approved;
            $this->existingImage = $this->event->image;
            // Load currently attached students
            $this->selectedStudents = $this->event->students()->pluck('users.id')->toArray();
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
            'is_approved' => $this->is_approved,
            'user_id' => auth()->id()
        ];

        if ($this->image) {
            $path = $this->image->store('events', 'public');
            $data['image'] = $path;
        }

        if ($this->event) {
            // Update existing event
            $this->event->update($data);
            // Sync students (attach/detach)
            $this->event->students()->sync($this->selectedStudents);
            session()->flash('message', 'Event updated successfully.');
        } else {
            // Create new event
            $event = Event::create($data);
            // Attach selected students
            $event->students()->attach($this->selectedStudents);
            session()->flash('message', 'Event created successfully.');
        }

        return redirect()->route('admin.events.index');
    }

    public function render()
    {
        return view('livewire.admin.event-form');
    }
}
