<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendeesDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $event;
    protected string $currency_symbol;

    public function __construct($event)
    {
        $this->event = $event;
        $this->currency_symbol = config('app.currency_symbol', '£');
    }

    public function collection()
    {
        return $this->event->attendees()
            ->with(['country', 'attendeeGroup', 'registrationTickets.ticket', 'user'])
            ->paid()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }

    public function map($attendee): array
    {
        $ticket_labels = $attendee->registrationTickets
            ->map(fn($rt) => trim(($rt->ticket->name ?? '—').' x'.$rt->quantity))
            ->filter()
            ->implode(', ');

        $total_value = $attendee->registrationTickets
            ->sum(fn($rt) => (float) $rt->quantity * (float) $rt->price_at_purchase);

        return [
            $attendee->title ?? '',
            $attendee->first_name ?? '',
            $attendee->last_name ?? '',
            $attendee->user->email ?? '',
            $attendee->country->name ?? '—',
            $attendee->attendeeGroup->title ?? '—',
            $ticket_labels ?: '—',
            $total_value > 0
                ? $this->currency_symbol.number_format($total_value, 2)
                : '—',
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'First Name',
            'Last Name',
            'Email',
            'Country',
            'Group',
            'Ticket(s)',
            'Value',
        ];
    }
}
