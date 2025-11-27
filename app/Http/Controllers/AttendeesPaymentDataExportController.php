<?php 

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendeesPaymentDataExport;

class AttendeesPaymentDataExportController
{
    public function __invoke(Event $event, Request $request)
    {
        $data = $request->validate([
            'date_from' => ['nullable','date'],
            'date_to'   => ['nullable','date','after_or_equal:date_from'],
        ]);

        $dateFrom = $data['date_from'] ?? null;
        $dateTo   = $data['date_to'] ?? null;

        $suffix   = trim(($dateFrom ?: '').'_'.($dateTo ?: ''), '_') ?: now()->format('Y-m-d');
        $filename = "attendee-payment-data-{$event->id}-{$suffix}.xlsx";

        return Excel::download(new AttendeesPaymentDataExport($event, $dateFrom, $dateTo), $filename);
    }
}
