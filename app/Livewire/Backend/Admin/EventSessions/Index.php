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
    public $event_session_groups = [];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->loadGroups();
    }

    private function loadGroups()
    {
        $this->event_session_groups = EventSessionGroup::where('event_id', $this->event->id)
            ->orderBy('display_order')
            ->get();

        $this->orders = $this->event_session_groups
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveUp($id)
    {
        $group = EventSessionGroup::findOrFail($id);

        if ($group->display_order <= 0) {
            return;
        }

        $group->decrement('display_order', 1);

        $this->loadGroups();
    }

    public function moveDown($id)
    {
        $group = EventSessionGroup::findOrFail($id);

        $group->increment('display_order', 1);

        $this->loadGroups();
    }

    public function updateOrder($id)
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $newOrder = (int) $this->orders[$id];

        EventSessionGroup::where('id', $id)->update([
            'display_order' => $newOrder,
        ]);

        $this->loadGroups();
    }

    public function deleteGroup($group_id)
    {
        EventSessionGroup::where('event_id', $this->event->id)
            ->findOrFail($group_id)
            ->delete();

        $this->loadGroups();

        session()->flash('success', 'Session group deleted successfully.');
    }

    public function deleteType(int $type_id)
    {
        EventSessionType::findOrFail($type_id)->delete();
        session()->flash('success', 'Session type deleted successfully.');
    }

    public function render()
    {
        return view('livewire.backend.admin.event-sessions.index', [
            'event_session_types' => EventSessionType::orderBy('friendly_name')->get(),
            'event'               => $this->event,
        ]);
    }
}
