<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendeesPaymentDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $event;
    protected ?string $dateFrom;
    protected ?string $dateTo;

    public function __construct($event, ?string $dateFrom = null, ?string $dateTo = null)
    {
        $this->event   = $event;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    public function collection()
    {
        return $this->event->attendees()
            ->with(['event', 'eventPaymentMethod', 'country'])
            ->when($this->dateFrom, fn($q) => $q->whereDate('paid_at', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn($q) => $q->whereDate('paid_at', '<=', $this->dateTo))
            ->get();
    }

    public function map($registration): array
    {
        $grossAmount   = (float) $registration->registration_total;
        $vatPercentage = (float) ($registration->event->vat_percentage ?? 0);

        $netAmount = $vatPercentage > 0
            ? round($grossAmount / (1 + ($vatPercentage / 100)), 2)
            : $grossAmount;

        $vatAmount = round($grossAmount - $netAmount, 2);

        return [
            trim(($registration->title ? $registration->title.' ' : '').$registration->first_name.' '.$registration->last_name),
            number_format($netAmount, 2),
            number_format($grossAmount, 2),
            number_format($vatAmount, 2),
            $registration->paid_at,
            $registration->eventPaymentMethod->name ?? 'N/A',
            $registration->country->name ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return ['Name','Net Amount','Gross Amount','VAT Amount','Payment Date','Payment Method','Country'];
    }
}
