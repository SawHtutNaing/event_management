<?php
namespace App\Livewire\Club;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Announcement;
use App\Models\Club;

class AnnouncementManager extends Component
{
    use WithPagination;

    public Club $club;
    public $showForm = false;
    public $announcementId;
    public $title;
    public $content;
    public $isPinned = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'isPinned' => 'boolean'
    ];

    public function mount($clubId)
    {
        $this->club = Club::findOrFail($clubId);
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $this->announcementId = $announcement->id;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->isPinned = $announcement->is_pinned;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'is_pinned' => $this->isPinned,
            'user_id' => auth()->id()
        ];

        if ($this->announcementId) {
            $announcement = Announcement::findOrFail($this->announcementId);
            $announcement->update($data);
            session()->flash('message', 'Announcement updated successfully!');
        } else {
            $this->club->announcements()->create($data);
            session()->flash('message', 'Announcement created successfully!');
        }

        $this->resetForm();
    }

    public function delete($announcementId)
    {
        Announcement::findOrFail($announcementId)->delete();
        session()->flash('message', 'Announcement deleted successfully!');
    }

    public function togglePin($announcementId)
    {
        $announcement = Announcement::findOrFail($announcementId);
        $announcement->update(['is_pinned' => !$announcement->is_pinned]);
    }

    public function resetForm()
    {
        $this->reset(['announcementId', 'title', 'content', 'isPinned', 'showForm']);
    }

    public function render()
    {
        return view('livewire.club.announcement-manager', [
            'announcements' => $this->club->announcements()
                ->orderBy('is_pinned', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'isAdmin' => $this->club->isAdmin(auth()->user())
        ]);
    }
}
