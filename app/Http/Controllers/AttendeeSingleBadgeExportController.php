<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class AttendeeSingleBadgeExportController extends Controller
{
    public function export(Event $event, Registration $attendee)
    {
        abort_if($attendee->event_id !== $event->id, 404);


        return $this->makePdf($event, $attendee);
    }

    public function exportSelf(Request $request, Event $event)
    {
        $attendee = Registration::with(['user','country','attendeeGroup'])
            ->where('event_id', $event->id)
            ->where('user_id', $request->user()->id)
            ->paid()
            ->firstOrFail();

        return $this->makePdf($event, $attendee);
    }

    protected function makePdf(Event $event, Registration $attendee)
    {
        $client_id = config('api.client_id');
        $qr_prefix = client_setting('check_in_app.qr_prefix');

        $attendee->loadMissing(['user','country','attendeeGroup']);

        $encoded = Hashids::connection('checkin')->encode($attendee->id, $client_id);

        $badge = (object) [
            'first_name'       => $attendee->user->first_name ?? '',
            'last_name'        => $attendee->user->last_name ?? '',
            'full_name'        => trim(($attendee->user->title ?? '').' '.($attendee->user->first_name ?? '').' '.($attendee->user->last_name ?? '')),
            'country'          => optional($attendee->country)->name ?? '',
            'qr_data'          => $qr_prefix . ':' . $encoded,
            'group_label'      => optional($attendee->attendeeGroup)->title ?? '',
            'group_color'      => $attendee->attendeeGroup->colour ?? '#FFFFFF',
            'group_text_color' => $attendee->attendeeGroup->label_colour ?? '#000000',
            'bg_color'         => '#FFFFFF',
        ];

        $width  = 86 * 2.83465;
        $height = 126 * 2.83465;

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'fontDir'                => resource_path('fonts'),
                'fontCache'              => storage_path('fonts'),
                'isRemoteEnabled'        => false,
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.attendees.badges.attendee', [
                'badges'          => [$badge],
                'header_logo_url' => resource_path('badges/header-logo.jpg'),
                'event_title'    => $event->title,
                'event_location' => $event->location,
            ])
            ->setPaper([0, 0, $width, $height], 'portrait');

        return $pdf->download('digital-badge.pdf');
    }
}
