<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class AveryPersonnelLabelController extends Controller
{
    public function export(Request $request, Event $event, Personnel $personnel)
    {
        $slot = max(1, min(4, (int) $request->get('slot', 1)));
        $mode = in_array($request->get('mode'), ['75mm_110mm','a6_full']) ? $request->get('mode') : '75mm_110mm';

        $cells = [
            1 => ['x' => 0.0,   'y' => 0.0],
            2 => ['x' => 105.0, 'y' => 0.0],
            3 => ['x' => 0.0,   'y' => 148.0],
            4 => ['x' => 105.0, 'y' => 148.0],
        ];

        if ($mode === 'a6_full') {
            $label_w = 105.0; $label_h = 148.0;
            $offset_x = $cells[$slot]['x'];
            $offset_y = $cells[$slot]['y'];
        } else {

            $label_w = 81.0; //3mm bleed
            $label_h = 116.0; //3mm bleed

            $cells = [
                1 => ['x' => 23.0,  'y' => 33.0],   // top-left
                2 => ['x' => 107, 'y' => 33.0],   // top-right
                3 => ['x' => 23.0,  'y' => 153.0],  // bottom-left
                4 => ['x' => 107, 'y' => 153.0],  // bottom-right
            ];

            $offset_x = $cells[$slot]['x'];
            $offset_y = $cells[$slot]['y'];
        }

        $vm = (object)[
            'line_1'       => $personnel->line_1 ?? '',
            'line_2'        => $personnel->line_2 ?? '',
            'line_3'          => $personnel->line_3 ?? '',
            'group_label'      => $personnel->group->title ?? '',
            'group_color'      => $personnel->group->label_background_colour ?? '#FFFFFF',
            'group_text_color' => $personnel->group->label_colour ?? '#000000',
            'bg_color'         => '#FFFFFF',
        ];

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'fontDir'                => storage_path('fonts'),
                'fontCache'              => storage_path('fonts'),
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.personnel.labels.avery', [
                'slot'      => $slot,
                'mode'      => $mode,
                'label_w'   => $label_w,
                'label_h'   => $label_h,
                'offset_x'  => $offset_x,
                'offset_y'  => $offset_y,
                'vm'        => $vm,
                'header_logo_url' => resource_path('badges/header-logo.jpg'),
                'event_title' => $event->title
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download(sprintf('label-%s-slot-%d.pdf', $mode, $slot));
    }
}
