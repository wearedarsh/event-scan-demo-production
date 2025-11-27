<?php

namespace App\Livewire\Backend\Admin\Tickets;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketGroup;

use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{

    public Event $event;
    public $tickets;
    public $ticket_groups;
    public $currency_symbol;

    public function deleteTicket(int $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        session()->flash('success', 'Ticket deleted successfully.');
    }

    public function deleteTicketGroup(int $id)
    {
        
        $ticketGroup = TicketGroup::findOrFail($id);
        
        $ticketGroup->tickets()->update(['deleted_at' => now()]);

        $ticketGroup->delete();

        session()->flash('success', 'Ticket group and tickets deleted successfully.');
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->currency_symbol = config('app.currency_symbol', '€');
    }

    public function render()
    {
        return view('livewire.backend.admin.tickets.index', [
            'event' => $this->event,
            'currency_symbol' => $this->currency_symbol
        ]);
    }

}
