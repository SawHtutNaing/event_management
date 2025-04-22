<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class UserClubs extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function leaveClub($clubId)
    {
        auth()->user()->clubs()->detach($clubId);
        session()->flash('message', 'You have left the club.');
    }

    public function render()
    {
        return view('livewire.user-clubs', [
            'clubs' => auth()->user()->clubs()
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->perPage)
        ]);
    }
}
