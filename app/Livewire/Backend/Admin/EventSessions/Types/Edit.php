<?php

namespace App\Livewire\Backend\Admin\EventSessions\Types;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EventSessionType;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public EventSessionType $type;

    public string $friendly_name;
    public int $active;

    public function mount(Event $event, EventSessionType $type)
    {
        $this->event = $event;
        $this->type = $type;

        $this->friendly_name = $type->friendly_name;
        $this->active = (bool) $type->active;
    }

    public function update()
    {
        $this->validate([
            'friendly_name' => 'required|string|max:255',
            'active' => 'boolean',
        ]);

        $this->type->update([
            'friendly_name' => $this->friendly_name,
            'active' => $this->active,
        ]);

        session()->flash('success', 'Session type updated successfully.');
        return redirect()->route('admin.events.event-sessions.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.event-sessions.types.edit');
    }
}
