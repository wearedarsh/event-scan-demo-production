<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportAttendeeExportController extends Controller
{
    public function export(Event $event)
    {
        // Paid attendees, A→Z
        $attendees = Registration::query()
            ->where('event_id', $event->id)
            ->paid()
            ->with(['country', 'attendeeGroup'])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id','title','first_name','last_name','country_id','attendee_group_id','event_id']);

        $report = [
            'title'  => 'Attendee Report',
            'totals' => [
                'attendees' => $attendees->count(),
            ],
        ];

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'isRemoteEnabled'        => false,
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.reports.attendees.exports.pdf', [
                'event'      => $event,
                'report'      => $report,
                'attendees'   => $attendees,
                'exported_at' => Carbon::now('Europe/London')->format('d/m/Y H:i'),
                'brand_color' => '#142B54',
                'logo_path'   => resource_path('brand/logo.jpg'),
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->download('attendee-report-' . $event->id . '.pdf');
    }
}
