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

    public $event_sessions = [];
    public $orders = [];

    public function mount(Event $event, EventSessionGroup $group)
    {
        $this->event = $event;
        $this->group = $group;

        $this->event_sessions = EventSession::where('event_session_group_id', $this->group->id)
            ->orderBy('display_order')
            ->orderBy('start_time')
            ->get();

        $this->orders = $this->event_sessions
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function updateSessionOrder($id, $value)
    {
        $value = max(1, (int) $value);

        EventSession::where('id', $id)->update([
            'display_order' => $value
        ]);

        $this->orders[$id] = $value;

        $this->dispatch('notify', 'Session order updated.');
    }

    public function delete(int $session_id)
    {
        $session = EventSession::findOrFail($session_id);
        $session->delete();

        session()->flash('success', 'Session deleted successfully.');
    }

    public function render()
    {
        $this->event_sessions = EventSession::where('event_session_group_id', $this->group->id)
            ->orderBy('display_order')
            ->orderBy('start_time')
            ->get();

        return view('livewire.backend.admin.event-sessions.manage', [
            'event_sessions' => $this->event_sessions
        ]);
    }
}
