<?php

namespace App\Livewire\Club;

use Livewire\Component;
use App\Models\Club;

class ClubDashboard extends Component
{
    public Club $club;

    public function mount($clubId)
    {
        $this->club = Club::with(['pinnedAnnouncements', 'announcements'])->findOrFail($clubId);
    }

    public function render()
    {
        return view('livewire.club.club-dashboard', [
            'isMember' => $this->club->isMember(auth()->user()),
            'isAdmin' => $this->club->isAdmin(auth()->user())
        ]);
    }
}
