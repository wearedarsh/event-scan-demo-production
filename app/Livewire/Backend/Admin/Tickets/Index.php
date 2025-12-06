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
    public $currency_symbol;

    // Holds only UI values – never overwritten by hydration
    public $orders = [
        'groups' => [],
        'tickets' => [],
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->currency_symbol = config('app.currency_symbol', '€');

        $this->loadOrders();
    }

    private function loadOrders()
    {
        // Load display order values into UI state
        $this->orders['groups'] = $this->event->allTicketGroups
            ->pluck('display_order', 'id')
            ->toArray();

        $this->orders['tickets'] = $this->event->allTickets
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function updateGroupOrder($groupId, $value)
    {
        $value = max(1, (int) $value);

        TicketGroup::where('id', $groupId)->update([
            'display_order' => $value
        ]);

        $this->orders['groups'][$groupId] = $value;

        $this->dispatch('notify', 'Group display order updated.');
    }

    public function updateTicketOrder($ticketId, $value)
    {
        $value = max(1, (int) $value);

        Ticket::where('id', $ticketId)->update([
            'display_order' => $value
        ]);

        $this->orders['tickets'][$ticketId] = $value;

        $this->dispatch('notify', 'Ticket display order updated.');
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

        // Soft delete tickets in group
        $group->tickets()->update(['deleted_at' => now()]);
        $group->delete();

        session()->flash('success', 'Ticket group and its tickets deleted successfully.');
        $this->loadOrders();
    }

    public function render()
    {

        $freshGroups = TicketGroup::where('event_id', $this->event->id)
            ->orderBy('name')
            ->get();

        $freshTickets = Ticket::where('event_id', $this->event->id)
            ->orderBy('name')
            ->get();

        $sortedGroups = $freshGroups->sortBy(
            fn ($g) => $this->orders['groups'][$g->id] ?? $g->display_order
        );

        $sortedTickets = $freshTickets->sortBy(
            fn ($t) => $this->orders['tickets'][$t->id] ?? $t->display_order
        );

        return view('livewire.backend.admin.tickets.index', [
            'event' => $this->event,
            'currency_symbol' => $this->currency_symbol,
            'event_ticket_groups' => $sortedGroups,
            'event_tickets' => $sortedTickets,
        ]);
    }

}
