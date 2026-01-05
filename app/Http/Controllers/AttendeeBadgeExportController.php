<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class AttendeeBadgeExportController extends Controller
{
    public function export(Event $event)
    {
        $client_id = config('api.client_id');
        $qr_prefix = client_setting('check_in_app.qr_prefix');

        $attendees = $event->attendees()->with(['user', 'country', 'attendeeGroup'])->get();

        $badges = $attendees->map(function ($attendee) use ($client_id, $qr_prefix) {
        $encoded = Hashids::connection('checkin')->encode($attendee->id, $client_id);

            return (object) [
                'first_name'        => $attendee->user->first_name ?? '',
                'last_name'         => $attendee->user->last_name ?? '',
                'full_name'         => trim(($attendee->user->title ?? '').' '.($attendee->user->first_name ?? '').' '.($attendee->user->last_name ?? '')),
                'country'           => optional($attendee->country)->name ?? '',
                'qr_data'           => $qr_prefix . ':' . $encoded,
                'group_label'       => optional($attendee->attendeeGroup)->title ?? '',
                'group_color'       => $attendee->attendeeGroup->colour ?? '#FFFFFF',
                'group_text_color'  => $attendee->attendeeGroup->label_colour ?? '#000000',
                'bg_color'          => '#FFFFFF',
            ];
        });

        $width  = 86 * 2.83465;
        $height = 126 * 2.83465; 

        $pdf = Pdf::setOptions([
            'chroot' => base_path(),
            'fontDir'    => resource_path('fonts'),
            'fontCache'  => storage_path('fonts'),
            'isRemoteEnabled' => false,
            'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.attendees.badges.attendee', [
                'badges'           => $badges,
                'header_logo_url'  => resource_path('badges/header-logo.jpg'),
                'event_title'     => $event->title,
                'event_location'     => $event->location,
            ])
            ->setPaper([0, 0, $width, $height], 'portrait');

        return $pdf->download('attendee-badges-export.pdf');
    }
}
