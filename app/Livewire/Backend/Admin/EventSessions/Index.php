<?php

namespace App\Livewire\Backend\Admin\EventSessions;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\EventSessionType;
use App\Models\EventSessionGroup;
use App\Models\Event;
use App\Traits\HandlesDisplayOrder;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use HandlesDisplayOrder;

    public Event $event;

    public array $orders = [];
    public $event_session_groups = [];

    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->loadGroups();
    }

    protected function loadGroups(): void
    {
        $this->event_session_groups = EventSessionGroup::where('event_id', $this->event->id)
            ->orderBy('display_order')
            ->get();

        $this->orders = $this->event_session_groups
            ->pluck('display_order', 'id')
            ->toArray();
    }


    public function moveGroupUp(int $id): void
    {
        $this->moveUp(EventSessionGroup::findOrFail($id));
        $this->loadGroups();
    }

    public function moveGroupDown(int $id): void
    {
        $this->moveDown(EventSessionGroup::findOrFail($id));
        $this->loadGroups();
    }

    public function updateGroupOrder(int $id): void
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $this->updateOrder(
            EventSessionGroup::findOrFail($id),
            (int) $this->orders[$id]
        );

        $this->loadGroups();
    }

    public function deleteGroup(int $group_id): void
    {
        EventSessionGroup::where('event_id', $this->event->id)
            ->findOrFail($group_id)
            ->delete();

        session()->flash('success', 'Session group deleted successfully.');
        $this->loadGroups();
    }

    public function deleteType(int $type_id): void
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
