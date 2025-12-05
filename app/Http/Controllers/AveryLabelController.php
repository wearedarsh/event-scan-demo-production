<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class AveryLabelController extends Controller
{
    public function export(Request $request, Event $event, Registration $attendee)
    {
        $mode = $request->get('mode', '80mm_80mm');

        $slot = (int) $request->get('slot', 1);

        $cells = [];

        if ($mode === '80mm_80mm') {
            // 80×80mm (with bleed)
            $label_w = 86.0;
            $label_h = 86.0;

            $cells = [
                1 => ['x' => 19.0,  'y' => 19.5],   // Row 1, Col 1
                2 => ['x' => 105.0, 'y' => 19.5],   // Row 1, Col 2

                3 => ['x' => 19.0,  'y' => 105.5],  // Row 2, Col 1
                4 => ['x' => 105.0, 'y' => 105.5],  // Row 2, Col 2

                5 => ['x' => 19.0,  'y' => 191.5],  // Row 3, Col 1
                6 => ['x' => 105.0, 'y' => 191.5],  // Row 3, Col 2
            ];
        }

        $offset_x = $cells[$slot]['x'];
        $offset_y = $cells[$slot]['y'];

        $client_id  = config('services.eventscan.client_id');
        $qr_prefix  = config('check-in-app.qr_prefix');
        $encoded    = Hashids::connection('checkin')->encode($attendee->id, $client_id);

        $attendee = (object)[
            'first_name'       => $attendee->user->first_name ?? '',
            'last_name'        => $attendee->user->last_name ?? '',
            'country'          => optional($attendee->country)->name ?? '',
            'qr_data'          => $qr_prefix . ':' . $encoded,
            'group_label'      => optional($attendee->attendeeGroup)->title ?? '',
            'group_color'      => optional($attendee->attendeeGroup)->colour ?? '#FFFFFF',
            'group_text_color' => optional($attendee->attendeeGroup)->label_colour ?? '#000000',
        ];

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'fontDir'                => resource_path('fonts'),
                'fontCache'              => storage_path('fonts'),
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.attendees.labels.avery', [
                'label_w'         => $label_w,
                'label_h'         => $label_h,
                'offset_x'        => $offset_x,
                'offset_y'        => $offset_y,
                'slot'            => $slot,
                'mode'            => $mode,
                'attendee'        => $attendee,
                'header_logo_url' => resource_path('badges/header-logo.jpg'),
                'event_title'     => $event->title,
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download(sprintf('label-%s-slot-%d.pdf', $mode, $slot));
    }
}
