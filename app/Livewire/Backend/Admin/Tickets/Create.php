<?php

namespace App\Livewire\Backend\Admin\Tickets;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;
    public $ticket_groups;
    public $name;
    public $price;
    public int $requires_document_upload = 0;
    public $max_volume = 1;
    public $requires_document_copy = '';
    public int $active = 1;
    public int $display_front_end = 0;
    public $display_order = 0;
    public $ticket_group_id;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->ticket_groups = TicketGroup::where('event_id', $event->id)->get();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_volume' => 'required|integer|min:1',
            'display_order' => 'required|numeric|min:0',
            'requires_document_copy' => 'required_if:requires_document_upload,1'
        ],[
            'requires_document_copy.required_if' => 'If this ticket requires a document upload please enter the document upload copy.'
        ]);

        Ticket::create([
            'event_id' => $this->event->id,
            'name' => $this->name,
            'price' => $this->price,
            'max_volume' => $this->max_volume ?? 1,
            'requires_document_copy' => $this->requires_document_copy,
            'display_front_end' => $this->display_front_end,
            'display_order' => $this->display_order,
            'ticket_group_id' => $this->ticket_group_id,
            'requires_document_upload' => $this->requires_document_upload,
            'active' => $this->active
        ]);

        session()->flash('success', 'Ticket created successfully.');
        return redirect()->route('admin.events.tickets.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.tickets.create', [
            'ticket_groups' => $this->ticket_groups
        ]);
    }
}
