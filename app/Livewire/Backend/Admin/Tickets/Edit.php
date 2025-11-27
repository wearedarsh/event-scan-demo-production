<?php

namespace App\Livewire\Backend\Admin\Tickets;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\TicketGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Ticket $ticket;
    public Event $event;
    public $ticket_groups;
    public $name;
    public $price;
    public int $requires_document_upload;
    public $max_volume;
    public $requires_document_copy;
    public int $active;
    public int $display_front_end;
    public $display_order;
    public $ticket_group_id;

    public function mount(Event $event, Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->event = $event;

        $this->name = $ticket->name;
        $this->price = $ticket->price;
        $this->requires_document_upload = (bool) $ticket->requires_document_upload;
        $this->max_volume = $ticket->max_volume;
        $this->requires_document_copy = $ticket->requires_document_copy;
        $this->active = (bool) $ticket->active;
        $this->display_front_end = (bool) $ticket->display_front_end;
        $this->display_order = $ticket->display_order;
        $this->ticket_group_id = $ticket->ticket_group_id;

        $this->ticket_groups = TicketGroup::where('event_id', $event->id)->get();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_volume' => 'required|integer|min:1',
            'display_order' => 'required|numeric|min:0',
            'requires_document_copy' => 'required_if:requires_document_upload,1'
        ],[
            'requires_document_copy.required_if' => 'If this ticket requires a document upload please enter the document upload copy'
        ]);

        $this->ticket->update([
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

        $this->ticket->save();

        session()->flash('success', 'Ticket updated successfully.');
        return redirect()->route('admin.events.tickets.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.tickets.edit', [
            'ticket' => $this->ticket,
            'ticket_groups' => $this->ticket_groups 
        ]);
    }
}
