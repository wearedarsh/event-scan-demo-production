<?php

namespace App\Livewire\Backend\Admin\EventSessions;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\EventSessionType;
use App\Models\EventSessionGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public Event $event;

    public function mount(Event $event){
        $this->event = $event;
    }

    public function deleteGroup(int $group_id)
    {
        $group = EventSessionGroup::where('event_id', $this->event->id)->findOrFail($group_id);
        $group->delete();

        session()->flash('success', 'Session group deleted successfully.');
    }

    public function deleteType(int $type_id)
    {
        $type = EventSessionType::findOrFail($type_id);
        $type->delete();

        session()->flash('success', 'Session type deleted successfully.');
    }

    public function render()
    {
        $event_session_types = EventSessionType::orderBy('friendly_name')->get();

        $event_session_groups = EventSessionGroup::where('event_id', $this->event->id)
            ->with(['sessions' => fn ($q) => $q->orderBy('display_order')->orderBy('start_time')])
            ->orderBy('display_order')
            ->orderBy('friendly_name')
            ->get();

        return view('livewire.backend.admin.event-sessions.index', [
            'event_session_types'  => $event_session_types,
            'event_session_groups' => $event_session_groups,
            'event'               => $this->event,
        ]);
    }
}
