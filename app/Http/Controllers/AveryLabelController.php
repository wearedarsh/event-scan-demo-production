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
        // Mode defaults to 75×110mm unless specified
        $mode = $request->get('mode', '75mm_110mm');

        // ---- FIXED 4 SLOT LOGIC ----
        $slot = (int) $request->get('slot', 1);
        $slot = max(1, min($slot, 4)); // clamp 1–4

        // ---- STATIC POSITION MAPS ----
        if ($mode === 'a6_full') {
            $label_w = 105.0;
            $label_h = 148.0;

            $cells = [
                1 => ['x' => 0.0,   'y' => 0.0],
                2 => ['x' => 105.0, 'y' => 0.0],
                3 => ['x' => 0.0,   'y' => 148.0],
                4 => ['x' => 105.0, 'y' => 148.0],
            ];
        } else {
            // 75×110mm (with bleed)
            $label_w = 81.0;
            $label_h = 116.0;

            $cells = [
                1 => ['x' => 23.0,  'y' => 33.0],
                2 => ['x' => 107.0, 'y' => 33.0],
                3 => ['x' => 23.0,  'y' => 153.0],
                4 => ['x' => 107.0, 'y' => 153.0],
            ];
        }

        $offset_x = $cells[$slot]['x'];
        $offset_y = $cells[$slot]['y'];

        // ---- QR CODE ENCODING ----
        $client_id  = config('services.eventscan.client_id');
        $qr_prefix  = config('check-in-app.qr_prefix');
        $encoded    = Hashids::connection('checkin')->encode($attendee->id, $client_id);

        $vm = (object)[
            'first_name'       => $attendee->user->first_name ?? '',
            'last_name'        => $attendee->user->last_name ?? '',
            'country'          => optional($attendee->country)->name ?? '',
            'qr_data'          => $qr_prefix . ':' . $encoded,
            'group_label'      => optional($attendee->attendeeGroup)->title ?? '',
            'group_color'      => optional($attendee->attendeeGroup)->colour ?? '#FFFFFF',
            'group_text_color' => optional($attendee->attendeeGroup)->label_colour ?? '#000000',
        ];

        // ---- PDF RENDER ----
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
                'vm'              => $vm,
                'header_logo_url' => resource_path('badges/header-logo.jpg'),
                'event_title'     => $event->title,
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download(sprintf('label-%s-slot-%d.pdf', $mode, $slot));
    }
}
