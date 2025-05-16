<?php

// app/Livewire/BatchManagement.php
namespace App\Livewire;

use App\Models\Batch;
use Livewire\Component;

class BatchManagement extends Component
{
    public $batches;
    public $name;
    public $editingId = null;

    public function mount()
    {
        $this->loadBatches();
    }

    public function loadBatches()
    {
        $this->batches = Batch::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255',
        ]);

        if ($this->editingId) {
            Batch::findOrFail($this->editingId)->update(['name' => $this->name]);
        } else {
            Batch::create(['name' => $this->name]);
        }

        $this->resetForm();
        $this->loadBatches();
    }

    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        $this->editingId = $batch->id;
        $this->name = $batch->name;
    }

    public function delete($id)
    {
        Batch::destroy($id);
        $this->loadBatches();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->editingId = null;
    }

    public function render()
    {
        return view('livewire.batch-management');
    }
}
