<?php

namespace App\Livewire\Backend\Admin\Tickets;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public Event $event;
    public string $currency_symbol;

    public $orders = [
        'groups' => [],
        'tickets' => [],
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->currency_symbol = client_setting('general.currency_symbol');

        $this->loadOrders();
    }

    private function loadOrders()
    {
        $this->orders['groups'] = $this->event->allTicketGroups
            ->pluck('display_order', 'id')
            ->toArray();

        $this->orders['tickets'] = $this->event->allTickets
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveGroupUp($id)
    {
        $group = TicketGroup::findOrFail($id);

        if ($group->display_order <= 1) {
            return;
        }

        $group->decrement('display_order', 1);

        $this->loadOrders();
    }

    public function moveGroupDown($id)
    {
        $group = TicketGroup::findOrFail($id);

        $group->increment('display_order', 1);

        $this->loadOrders();
    }

    public function updateGroupOrder($id)
    {
        if (!isset($this->orders['groups'][$id])) {
            return;
        }

        $newOrder = max(1, (int) $this->orders['groups'][$id]);

        TicketGroup::where('id', $id)
            ->update(['display_order' => $newOrder]);

        $this->loadOrders();
    }


    public function moveTicketUp($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->display_order <= 1) {
            return;
        }

        $ticket->decrement('display_order', 1);

        $this->loadOrders();
    }

    public function moveTicketDown($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->increment('display_order', 1);

        $this->loadOrders();
    }

    public function updateTicketOrder($id)
    {
        if (!isset($this->orders['tickets'][$id])) {
            return;
        }

        $newOrder = max(1, (int) $this->orders['tickets'][$id]);

        Ticket::where('id', $id)
            ->update(['display_order' => $newOrder]);

        $this->loadOrders();
    }


    public function deleteTicket(int $id)
    {
        Ticket::findOrFail($id)->delete();

        session()->flash('success', 'Ticket deleted successfully.');
        $this->loadOrders();
    }

    public function deleteTicketGroup(int $id)
    {
        $group = TicketGroup::findOrFail($id);

        $group->tickets()->update(['deleted_at' => now()]);
        $group->delete();

        session()->flash('success', 'Ticket group and its tickets deleted successfully.');
        $this->loadOrders();
    }


    public function render()
    {
        $groups = TicketGroup::where('event_id', $this->event->id)->get()
            ->sortBy(fn($g) => $this->orders['groups'][$g->id] ?? $g->display_order);

        $tickets = Ticket::where('event_id', $this->event->id)->get()
            ->sortBy(fn($t) => $this->orders['tickets'][$t->id] ?? $t->display_order);

        return view('livewire.backend.admin.tickets.index', [
            'event' => $this->event,
            'currency_symbol' => $this->currency_symbol,
            'event_ticket_groups' => $groups,
            'event_tickets' => $tickets,
        ]);
    }
}
