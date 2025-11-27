<?php

namespace App\Livewire\Backend\Admin\Attendees\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\Event;
use App\Models\AttendeeGroup;
use Livewire\Attributes\Computed;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Event $event;

    public string $search = '';

    protected string $paginationTheme = 'bootstrap';

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $attendee_groups = $this->event->attendeeGroups()
            ->withCount('attendees')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('title')
            ->paginate(10);

        return view('livewire.backend.admin.attendees.groups.index', compact('attendee_groups'));
    }

    public function deleteAttendeeGroup(int $id)
    {
        $group = AttendeeGroup::findOrFail($id);

        if ($group->attendees()->count() > 0) {
            session()->flash('error', 'You cannot delete a group with assigned attendees.');
            return;
        }

        $group->delete();

        session()->flash('success', 'Attendee group deleted successfully.');
    }
}
