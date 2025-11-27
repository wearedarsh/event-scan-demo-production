<?php

namespace App\Livewire\Backend\Admin\Tickets\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TicketGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;

    public string $name;
    public string $description = '';
    public int $display_order = 0;
    public int $active = 1;
    public int $multiple_select = 0;
    public int $required = 0;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'active' => 'boolean',
            'multiple_select' => 'boolean',
            'required' => 'boolean',
        ]);

        TicketGroup::create([
            'event_id' => $this->event->id,
            'name' => $this->name,
            'description' => $this->description,
            'display_order' => $this->display_order,
            'active' => $this->active,
            'multiple_select' => $this->multiple_select,
            'required' => $this->required,
        ]);

        session()->flash('success', 'Ticket group created successfully.');
        return redirect()->route('admin.events.tickets.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.tickets.groups.create');
    }
}
