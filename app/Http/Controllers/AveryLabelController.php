<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Event;
use App\Models\LabelFormat;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class AveryLabelController extends Controller
{
    public function export(Request $request, Event $event, Registration $attendee)
    {
        $mode = $request->get('mode', 'avery_80x80');

        /** @var LabelFormat $format */
        $format = LabelFormat::where('key_name', $mode)->where('active', true)->firstOrFail();

        $slot = (int) $request->get('slot', 1);
        $slot = max(1, min($slot, $format->labels_per_sheet));

        $position = $format->positionForSlot($slot);

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
            'bg_color'         => '#FFFFFF',
        ];

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'fontDir'                => storage_path('fonts'),
                'fontCache'              => storage_path('fonts'),
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.attendees.labels.avery', [
                'label_w'   => $format->label_width_mm,
                'label_h'   => $format->label_height_mm,
                'offset_x'  => $position['x'],
                'offset_y'  => $position['y'],
                'slot'      => $slot,
                'mode'      => $format->key_name,
                'vm'        => $vm,
                'header_logo_url' => resource_path('badges/header-logo.jpg'),
                'event_title'     => $event->title,
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download(sprintf('label-%s-slot-%d.pdf', $format->key_name, $slot));
    }
}

