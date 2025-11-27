<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class PersonnelBadgeExportController extends Controller
{
    public function export(Event $event)
    {

        $personnel = $event->personnel()->with(['group'])->get();

        $badges = $personnel->map(function ($personnel){

            return (object) [
                'line_1'         => $personnel->line_1 ?? '',
                'line_2'         => $personnel->line_2 ?? '',
                'line_3'         => $personnel->line_3 ?? '',
                'group_label'    => $personnel->group->title ?? '',
                'group_color'    => $personnel->group->label_background_colour ?? '#ffffff',
                'group_text_color' => $personnel->group->label_colour ?? '#000000',
                'bg_color'         => '#FFFFFF',
            ];
        });

        $width  = 86 * 2.83465;
        $height = 126 * 2.83465; 

        $pdf = Pdf::setOptions([
                'chroot' => base_path(),
                'fontDir'    => storage_path('fonts'),
                'fontCache'  => storage_path('fonts'),
                'isRemoteEnabled' => false,
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.personnel.badges.personnel', [
                'badges' => $badges,
                'header_logo_url'   => resource_path('badges/header-logo.jpg'),
                'event_title'      => $event->title,
                'event_location'   => $event->location
            ])
            ->setPaper([0, 0, $width, $height], 'portrait');

        return $pdf->download('personnel-badges-export.pdf');
    }
}
