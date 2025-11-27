<?php

namespace App\Livewire\Backend\Admin\EventSessions\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EventSessionGroup;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;

    public string $friendly_name;
    public int $display_order = 0;
    public int $active = 1;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function store()
    {
        $this->validate([
            'friendly_name' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        EventSessionGroup::create([
            'event_id' => $this->event->id,
            'friendly_name' => $this->friendly_name,
            'display_order' => $this->display_order,
            'active' => $this->active,
        ]);

        session()->flash('success', 'Session group created successfully.');
        return redirect()->route('admin.events.event-sessions.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        Log::info('Rendering Create blade, or should be');
        return view('livewire.backend.admin.event-sessions.groups.create');
    }
}
