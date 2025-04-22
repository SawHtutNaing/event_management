<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Club;

class ClubList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function joinClub($clubId)
    {
        $club = Club::findOrFail($clubId);
        auth()->user()->clubs()->attach($clubId);
        session()->flash('message', 'You have joined the club!');
    }

    public function leaveClub($clubId)
    {
        auth()->user()->clubs()->detach($clubId);
        session()->flash('message', 'You have left the club.');
    }

    public function render()
    {
        return view('livewire.club-list', [
            'clubs' => Club::where('is_active', true)
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->paginate($this->perPage),
            'userClubs' => auth()->check() ? auth()->user()->clubs : collect()
        ]);
    }
}
