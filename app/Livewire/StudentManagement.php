<?php
namespace App\Livewire;

use App\Models\User;
use App\Models\Batch;
use Livewire\Component;

class StudentManagement extends Component
{
    public $students;
    public $batches;
    public $selectedStudentIds = [];
    public $selectedBatch;

    public function mount()
    {
        $this->students = User::whereHas('roles', fn($q) => $q->where('role_id', 2))->get();
        $this->batches = Batch::all();
    }

    public function attachBatch()
    {
        if (!empty($this->selectedStudentIds) && $this->selectedBatch) {
            foreach ($this->selectedStudentIds as $studentId) {
                $student = User::find($studentId);
                if ($student) {
                    $student->batches()->syncWithoutDetaching([$this->selectedBatch]);
                }
            }

            // Refresh students list (optional)
            $this->students = User::whereHas('roles', fn($q) => $q->where('role_id', 2))->get();
        }
    }

    public function detachBatch($studentId, $batchId)
    {
        $student = User::find($studentId);
        if ($student) {
            $student->batches()->detach($batchId);
        }

        // Refresh students list (optional)
        $this->students = User::whereHas('roles', fn($q) => $q->where('role_id', 2))->get();
    }

    public function render()
    {
        return view('livewire.student-management');
    }
}
