<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;
use Vinkla\Hashids\Facades\Hashids;

class AveryPersonnelLabelController extends Controller
{
    public function export(Request $request, Event $event, Personnel $personnel)
    {
        $mode = $request->get('mode', '80mm_80mm');
        $slot = (int) $request->get('slot', 1);

        $cells = [];

        if ($mode === '80mm_80mm') {
            $label_w = 86.0;
            $label_h = 86.0;

            $cells = [
                1 => ['x' => 19.0,  'y' => 19.5],
                2 => ['x' => 105.0, 'y' => 19.5],
                3 => ['x' => 19.0,  'y' => 105.5],
                4 => ['x' => 105.0, 'y' => 105.5],
                5 => ['x' => 19.0,  'y' => 191.5],
                6 => ['x' => 105.0, 'y' => 191.5],
            ];
        }

        $offset_x = $cells[$slot]['x'];
        $offset_y = $cells[$slot]['y'];

        // PERSONAL -> DISPLAY LINES ON LABEL
        $labelData = (object)[
            'line_1' => $personnel->line_1,
            'line_2' => $personnel->line_2,
            'line_3' => $personnel->line_3,
            'group_label' => optional($personnel->group)->title ?? '',
            'group_color' => optional($personnel->group)->label_background_colour ?? '#FFFFFF',
            'group_text_color' => optional($personnel->group)->label_colour ?? '#000000',
        ];

        $pdf = Pdf::setOptions([
            'chroot'                 => base_path(),
            'fontDir'                => resource_path('fonts'),
            'fontCache'              => storage_path('fonts'),
            'enable_font_subsetting' => true,
        ])
            ->loadView('livewire.backend.admin.personnel.labels.avery', [
                'label_w'   => $label_w,
                'label_h'   => $label_h,
                'offset_x'  => $offset_x,
                'offset_y'  => $offset_y,
                'slot'      => $slot,
                'mode'      => $mode,
                'personnel' => $labelData,
                'event_title' => $event->title,
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download(sprintf('personnel-label-%s-slot-%d.pdf', $mode, $slot));
    }
}
