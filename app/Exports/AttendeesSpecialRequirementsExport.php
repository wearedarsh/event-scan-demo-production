<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendeesSpecialRequirementsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function collection()
    {
        return $this->event->attendees()->whereNotNull('special_requirements')->get();
    }

    public function map($registration): array
    {
        return [
            $registration->title . ' ' . $registration->first_name . ' ' . $registration->last_name,
            $registration->special_requirements
        ];
    }


    public function headings(): array
    {
        return [
            'Name',
            'Special requirements'
        ];
    }
}
