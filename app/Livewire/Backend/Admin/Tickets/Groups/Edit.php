<?php

namespace App\Livewire\Backend\Admin\Tickets\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TicketGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public TicketGroup $ticket_group;

    public string $name;
    public string $description = '';
    public int $display_order = 0;
    public int $active;
    public int $multiple_select;
    public int $required;

    public function mount(Event $event, TicketGroup $ticket_group)
    {
        $this->event = $event;
        $this->ticket_group = $ticket_group;

        $this->name = $ticket_group->name;
        $this->description = $ticket_group->description;
        $this->display_order = $ticket_group->display_order;
        $this->active = (bool) $ticket_group->active;
        $this->multiple_select = (bool) $ticket_group->multiple_select;
        $this->required = (bool) $ticket_group->required;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'active' => 'boolean',
            'multiple_select' => 'boolean',
            'required' => 'boolean',
        ]);

        $this->ticket_group->update([
            'name' => $this->name,
            'description' => $this->description,
            'display_order' => $this->display_order,
            'active' => $this->active,
            'multiple_select' => $this->multiple_select,
            'required' => $this->required,
        ]);

        session()->flash('success', 'Ticket group updated successfully.');
        return redirect()->route('admin.events.tickets.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.tickets.groups.edit');
    }
}
