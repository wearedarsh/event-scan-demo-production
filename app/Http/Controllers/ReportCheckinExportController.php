<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\CheckIn;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportCheckinExportController extends Controller
{
    public function export(Event $event)
    {
        // Denominator for %: paid attendees on this event
        $totalAttendees = (int) Registration::query()
            ->where('event_id', $event->id)
            ->paid()
            ->count();

        // All check-ins for this event with needed relations
        $ins = CheckIn::query()
            ->with([
                'checkedInBy:id,first_name,last_name',
                'session:id,title,event_session_group_id',
                'session.group:id,friendly_name',
            ])
            ->where('event_id', $event->id)
            ->get(['id','event_session_id','event_id','checked_in_by','checked_in_at','checked_in_route']);

        // By user
        $userCounts = [];
        foreach ($ins as $ci) {
            $u = $ci->checkedInBy;
            $label = $u ? trim(($u->first_name ?? '') . ' ' . ($u->last_name ?? '')) : 'Unassigned';
            $userCounts[$label] = ($userCounts[$label] ?? 0) + 1;
        }
        arsort($userCounts);
        $by_user = [];
        foreach ($userCounts as $label => $count) {
            $by_user[] = ['label' => $label, 'count' => $count];
        }

        // By session grouped by session group
        $grouped = [];
        foreach ($ins as $ci) {
            $gName = $ci->session?->group?->friendly_name ?: 'Unassigned group';
            $sName = $ci->session?->title ?: 'Unassigned session';
            $grouped[$gName][$sName] = ($grouped[$gName][$sName] ?? 0) + 1;
        }

        $by_groups = [];
        foreach ($grouped as $groupName => $sessions) {
            arsort($sessions);
            $rows = [];
            foreach ($sessions as $sessionTitle => $count) {
                $pct = $totalAttendees > 0 ? (int) round(($count / $totalAttendees) * 100) : 0;
                $rows[] = [
                    'session' => $sessionTitle,
                    'count'   => $count,
                    'pct'     => $pct,
                ];
            }
            $by_groups[] = [
                'group' => $groupName,
                'rows'  => $rows,
            ];
        }
        usort($by_groups, fn($a,$b) => strcasecmp($a['group'], $b['group']));

        // By route (manual / qr / etc.)
        $by_route_counts = [];
        foreach ($ins as $ci) {
            $route = $ci->checked_in_route ?: 'unspecified';
            $by_route_counts[$route] = ($by_route_counts[$route] ?? 0) + 1;
        }
        ksort($by_route_counts);
        $by_route = $by_route_counts;

        $report = [
            'title'     => 'Check-ins Report',
            'by_user'   => $by_user,
            'by_groups' => $by_groups,
            'by_route'  => $by_route,
            'totals'    => [
                'attendees' => $totalAttendees,
                'checkins'  => $ins->count(),
            ],
        ];

        $pdf = Pdf::setOptions([
                'chroot'                 => base_path(),
                'isRemoteEnabled'        => false,
                'enable_font_subsetting' => true,
            ])
            ->loadView('livewire.backend.admin.reports.checkin.exports.pdf', [
                'event'      => $event,
                'report'      => $report,
                'exported_at' => Carbon::now('Europe/London')->format('d/m/Y H:i'),
                'brand_color' => '#142B54',
                'logo_path'   => resource_path('brand/logo.jpg'),
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->download('checkin-report-' . $event->id . '.pdf');
    }
}
