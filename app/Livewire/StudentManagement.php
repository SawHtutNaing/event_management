<?php
namespace App\Livewire;

use App\Models\User;
use App\Models\Batch;
use Livewire\Component;

class StudentManagement extends Component
{
    public $students;
    public $batches;
    public $selectedStudent;
    public $selectedBatch;

    public function mount()
    {
        $this->students = User::whereHas('roles', fn($q) => $q->where('role_id', 2))->get();
        $this->batches = Batch::all();
    }

    public function selectStudent($id)
    {
        $this->selectedStudent = User::find($id);
    }

    public function attachBatch()
    {
        if ($this->selectedStudent && $this->selectedBatch) {
            $this->selectedStudent->batches()->syncWithoutDetaching([$this->selectedBatch]);
            $this->selectedStudent = $this->selectedStudent->fresh(); // Refresh relation
        }
    }

    public function detachBatch($batchId)
    {
        if ($this->selectedStudent) {
            $this->selectedStudent->batches()->detach($batchId);
            $this->selectedStudent = $this->selectedStudent->fresh();
        }
    }

    public function render()
    {
        return view('livewire.student-management');
    }
}
