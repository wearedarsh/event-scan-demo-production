<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class BlankBadgeExportController extends Controller
{
    public function export(Event $event)
    {
        $width  = 86 * 2.83465;
        $height = 126 * 2.83465; 

        $pdf = Pdf::setOptions([
            'chroot' => base_path(),
            ])
            ->loadView('livewire.backend.admin.attendees.badges.blank-attendee', [
                'header_logo_url'   => resource_path('badges/header-logo.jpg'),
                'event_title'      => $event->title,
                'event_location'   => $event->location,
                'bg_color' => '#ffffff'
            ])
            ->setPaper([0, 0, $width, $height], 'portrait');

        return $pdf->download('attendee-blank-badge-export.pdf');
    }
}
