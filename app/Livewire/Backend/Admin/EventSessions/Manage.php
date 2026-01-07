<?php

namespace App\Livewire\Backend\Admin\EventSessions;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSessionGroup;
use App\Models\EventSession;
use App\Traits\HandlesDisplayOrder;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    use HandlesDisplayOrder;

    public Event $event;
    public EventSessionGroup $group;

    public array $orders = [];

    public function mount(Event $event, EventSessionGroup $group): void
    {
        $this->event = $event;
        $this->group = $group;

        $this->loadSessions();
    }

    protected function loadSessions(): void
    {
        $sessions = EventSession::where('event_session_group_id', $this->group->id)
            ->orderBy('display_order')
            ->orderBy('start_time')
            ->get();

        $this->orders = $sessions
            ->pluck('display_order', 'id')
            ->toArray();
    }


    public function moveSessionUp(int $id): void
    {
        $this->moveUp(EventSession::findOrFail($id));
        $this->loadSessions();
    }

    public function moveSessionDown(int $id): void
    {
        $this->moveDown(EventSession::findOrFail($id));
        $this->loadSessions();
    }

    public function updateSessionOrder(int $id): void
    {
        if (!isset($this->orders[$id])) {
            return;
        }

        $this->updateOrder(
            EventSession::findOrFail($id),
            (int) $this->orders[$id]
        );

        $this->loadSessions();
    }

    public function delete(int $session_id): void
    {
        EventSession::findOrFail($session_id)->delete();
        session()->flash('success', 'Session deleted successfully.');
        $this->loadSessions();
    }

    public function render()
    {
        return view('livewire.backend.admin.event-sessions.manage', [
            'event_sessions' => EventSession::where('event_session_group_id', $this->group->id)
                ->get()
                ->sortBy(fn ($s) => $this->orders[$s->id] ?? $s->display_order),
        ]);
    }
}
