<?php

namespace App\Livewire\Backend\Admin\Reports\Attendees;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use App\Exports\AttendeesPaymentDataExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('livewire.backend.admin.layouts.app')]
class View extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function exportAttendees(Event $event)
    {
        return Excel::download(
            new AttendeesPaymentDataExport($event, true),
            "attendees-export.xlsx"
        );
    }

    public function render()
    {
        $attendees = Registration::query()
            ->where('event_id', $this->event->id)
            ->paid()
            ->with([
                'country',
                'attendeeGroup',
                'registrationTickets.ticket',
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get([
                'id','title','first_name','last_name','country_id','attendee_group_id','event_id'
            ]);

        $total = $attendees->count();

        // Breakdown: distinct attendees per ticket (paid only)
        $ticket_breakdown = DB::table('registration_tickets as rt')
            ->join('registrations as r', 'r.id', '=', 'rt.registration_id')
            ->join('tickets as t', 't.id', '=', 'rt.ticket_id')
            ->where('r.event_id', $this->event->id)
            ->where('r.payment_status', 'paid')
            ->whereNull('r.deleted_at')
            ->whereNull('t.deleted_at')
            ->selectRaw('rt.ticket_id, t.name, COUNT(DISTINCT rt.registration_id) as attendees_count')
            ->groupBy('rt.ticket_id', 't.name')
            ->orderByRaw('MIN(t.display_order) IS NULL, MIN(t.display_order) ASC, t.name ASC')
            ->get()
            ->map(function ($row) use ($total) {
                $percent = $total > 0 ? round(($row->attendees_count / $total) * 100, 1) : 0;
                return [
                    'ticket_id'       => (int) $row->ticket_id,
                    'name'            => $row->name,
                    'attendees_count' => (int) $row->attendees_count,
                    'percent'         => $percent,
                ];
            });

        $currency_symbol = client_setting('general.currency_symbol');

        return view('livewire.backend.admin.reports.attendees.view', [
            'attendees'        => $attendees,
            'total'            => $total,
            'ticket_breakdown' => $ticket_breakdown,
            'currency_symbol'  => $currency_symbol,
        ]);
    }
}
