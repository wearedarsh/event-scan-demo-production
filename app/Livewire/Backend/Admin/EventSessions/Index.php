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
    public $orders = [];
    public $event_session_groups;

    public function mount(Event $event){
        $this->event = $event;

        $this->event_session_groups = $this->event->eventSessionGroups()
        ->orderBy('display_order')
        ->get();

        $this->orders = $this->event_session_groups
        ->pluck('display_order', 'id')
        ->toArray();
    }

    public function updateSessionGroupOrder($id, $value)
    {
        $value = max(1, (int) $value);

        \App\Models\EventSessionGroup::where('id', $id)->update([
            'display_order' => $value
        ]);

        $this->orders[$id] = $value;

        $this->dispatch('notify', 'Display order updated.');
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

        $this->event_session_groups = EventSessionGroup::where('event_id', $this->event->id)
            ->with(['sessions' => fn ($q) => $q->orderBy('display_order')->orderBy('start_time')])
            ->orderBy('display_order')
            ->orderBy('friendly_name')
            ->get();

        return view('livewire.backend.admin.event-sessions.index', [
            'event_session_types'  => $event_session_types,
            'event'               => $this->event,
        ]);
    }
}
