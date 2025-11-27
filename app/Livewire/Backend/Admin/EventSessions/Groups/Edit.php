<?php

namespace App\Livewire\Backend\Admin\EventSessions\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EventSessionGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public EventSessionGroup $group;

    public string $friendly_name;
    public int $display_order = 0;
    public int $active;

    public function mount(Event $event, EventSessionGroup $group)
    {
        $this->event = $event;
        $this->group = $group;

        $this->friendly_name = $group->friendly_name;
        $this->display_order = $group->display_order;
        $this->active = (bool) $group->active;
    }

    public function update()
    {
        $this->validate([
            'friendly_name' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        $this->group->update([
            'event_id' => $this->event->id,
            'friendly_name' => $this->friendly_name,
            'display_order' => $this->display_order,
            'active' => $this->active,
        ]);

        session()->flash('success', 'Session group updated successfully.');
        return redirect()->route('admin.events.event-sessions.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.event-sessions.groups.edit');
    }
}
