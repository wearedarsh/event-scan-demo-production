<?php

namespace App\Livewire\Backend\Admin\Reports\Checkin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\CheckIn;
use App\Models\Registration;

#[Layout('livewire.backend.admin.layouts.app')]
class View extends Component
{
    public Event $event;

    public array $report = [
        'by_user'   => [],
        'by_groups' => [],
        'totals'    => ['attendees' => 0, 'checkins' => 0],
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->buildReport();
    }

    protected function buildReport(): void
    {
        $totalAttendees = (int) Registration::query()
            ->where('event_id', $this->event->id)
            ->paid()
            ->count();

        $ins = CheckIn::query()
            ->with([
                'checkedInBy:id,first_name,last_name',
                'session:id,title,event_session_group_id,display_order',
                'session.group:id,friendly_name,display_order',
            ])
            ->where('event_id', $this->event->id)
            ->get(['id','event_session_id','event_id','checked_in_by','checked_in_at','checked_in_route']);

        $userCounts = [];
        foreach ($ins as $ci) {
            $u = $ci->checkedInBy;
            $label = $u ? trim(($u->first_name ?? '').' '.($u->last_name ?? '')) : 'Unassigned';
            $userCounts[$label] = ($userCounts[$label] ?? 0) + 1;
        }
        arsort($userCounts);
        $by_user = collect($userCounts)->map(fn($count,$label)=>['label'=>$label,'count'=>$count])->values()->all();

        $grouped = [];
        foreach ($ins as $ci) {
            $gName  = $ci->session?->group?->friendly_name ?: 'Unassigned group';
            $gOrder = $ci->session?->group?->display_order ?? 9999;

            $sName  = $ci->session?->title ?: 'Unassigned session';
            $sOrder = $ci->session?->display_order ?? 9999;

            if (!isset($grouped[$gName])) {
                $grouped[$gName] = [
                    'order'    => $gOrder,
                    'sessions' => [],
                ];
            }

            if (!isset($grouped[$gName]['sessions'][$sName])) {
                $grouped[$gName]['sessions'][$sName] = [
                    'count' => 0,
                    'order' => $sOrder,
                ];
            }

            $grouped[$gName]['sessions'][$sName]['count']++;
        }

        $by_groups = [];
        foreach ($grouped as $groupName => $groupData) {
            $sessions = $groupData['sessions'];

            // sort sessions by display_order
            uasort($sessions, fn($a, $b) => $a['order'] <=> $b['order']);

            $rows = [];
            foreach ($sessions as $sessionTitle => $data) {
                $pct = $totalAttendees > 0 ? (int) round(($data['count'] / $totalAttendees) * 100) : 0;
                $rows[] = [
                    'session' => $sessionTitle,
                    'count'   => $data['count'],
                    'pct'     => $pct,
                ];
            }

            $by_groups[] = [
                'group' => $groupName,
                'order' => $groupData['order'],
                'rows'  => $rows,
            ];
        }

        usort($by_groups, fn($a, $b) => $a['order'] <=> $b['order']);

        $by_route = $ins->groupBy('checked_in_route')->map->count()->all();

        $this->report = [
            'by_user'   => $by_user,
            'by_groups' => $by_groups,
            'by_route'  => $by_route,
            'totals'    => [
                'attendees' => $totalAttendees,
                'checkins'  => $ins->count(),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.backend.admin.reports.checkin.view');
    }
}
