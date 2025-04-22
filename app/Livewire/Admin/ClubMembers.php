<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Club;

class ClubMembers extends Component
{
    public $club;
    public $search = '';

    public function mount($clubId)
    {

        $this->club = Club::with(['members'])->findOrFail($clubId);
    }

    public function removeMember($userId)
    {
        $this->club->members()->detach($userId);
        $this->club->refresh();
    }

    public function promoteToAdmin($userId)
    {
        $this->club->members()->updateExistingPivot($userId, ['role' => 'admin']);
        $this->club->refresh();
    }

    public function demoteToMember($userId)
    {
        $this->club->members()->updateExistingPivot($userId, ['role' => 'member']);
        $this->club->refresh();
    }

    public function render()
    {

        $members = $this->club->members()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);


        return view('livewire.admin.club-members', [
            'members' => $members
        ]);
    }
}
