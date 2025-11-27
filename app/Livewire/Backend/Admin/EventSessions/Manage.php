<?php

namespace App\Livewire\Backend\Admin\EventSessions;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSessionGroup;
use App\Models\EventSession;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public Event $event;
    public EventSessionGroup $group;
    public $event_sessions;

    public function mount(Event $event, EventSessionGroup $group)
    {
        $this->event = $event;
        $this->group = $group;
        $this->event_sessions = EventSession::where('event_session_group_id', $this->group->id)->get();
    }

    public function delete(int $session_id)
    {
        $session = EventSession::findOrFail($session_id);
        $session->delete();

        session()->flash('success', 'Session deleted successfully.');
        return redirect()->route('admin.events.event-sessions.index', ['event' => $this->event->id, 'group' => $this->group->id]);
    }


    public function render()
    {

        return view('livewire.backend.admin.event-sessions.manage', [
            'event_sessions' => $this->event_sessions
        ]);
    }
}
