<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Club;
use Livewire\WithFileUploads;

class ClubManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $showForm = false;
    public $clubId;
    public $name;
    public $description;
    public $image;
    public $isActive = true;
    public $existingImage;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'isActive' => 'boolean'
    ];

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($clubId)
    {
        $club = Club::findOrFail($clubId);
        $this->clubId = $club->id;
        $this->name = $club->name;
        $this->description = $club->description;
        $this->isActive = $club->is_active;
        $this->existingImage = $club->image;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->isActive,
            'founder_id' => auth()->id()
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('clubs', 'public');
        }

        if ($this->clubId) {
            $club = Club::findOrFail($this->clubId);
            $club->update($data);
            session()->flash('message', 'Club updated successfully!');
        } else {
            Club::create($data);
            session()->flash('message', 'Club created successfully!');
        }

        $this->resetForm();
    }

    public function delete($clubId)
    {
        Club::findOrFail($clubId)->delete();
        session()->flash('message', 'Club deleted successfully!');
    }

    public function resetForm()
    {
        $this->reset(['clubId', 'name', 'description', 'image', 'isActive', 'showForm', 'existingImage']);
    }

    public function render()
    {
        return view('livewire.admin.club-management', [
            'clubs' => Club::when($this->search, function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->perPage)
        ]);
    }


    public function view_members($id){
        return redirect()->route('admin.clubs.members', ['clubId' => $id]);

    }
}
