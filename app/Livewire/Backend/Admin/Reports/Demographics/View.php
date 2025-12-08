<?php

namespace App\Livewire\Backend\Admin\Reports\Demographics;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Collection;

#[Layout('livewire.backend.admin.layouts.app')]
class View extends Component
{
    public Event $event;

    public ?string $date_from = null;
    public ?string $date_to   = null;

    public array $report = [];
    public array $charts = [];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->build_report();
    }

    public function updated($prop)
    {
        if (in_array($prop, ['date_from', 'date_to'])) {
            $this->build_report();
        }
    }

    /**
     * Build the demographics report (matches financial structure)
     */
    protected function build_report(): void
    {
        $regs = Registration::query()
            ->with([
                'country:id,name',
                'AttendeeType:id,name'
            ])
            ->where('event_id', $this->event->id)
            ->paid()
            ->when($this->date_from, fn ($q) => $q->whereDate('paid_at', '>=', $this->date_from))
            ->when($this->date_to,   fn ($q) => $q->whereDate('paid_at', '<=', $this->date_to))
            ->get(['id', 'country_id', 'attendee_type_id', 'attendee_type_other']);

        // ---- BREAKDOWNS ----
        $country = $this->sortTally(
            $this->tally(
                $regs->map(fn ($r) => $r->country->name ?? 'Unspecified')
            )
        );

        $attendeeType = $this->sortTally(
            $this->tally(
                $regs->map(function ($r) {
                    if ($r->AttendeeType?->name) return $r->AttendeeType->name;
                    if ($r->attendee_type_other) return trim($r->attendee_type_other);
                    return 'Unspecified';
                })
            )
        );

        // ---- REPORT OUTPUT (matches financial structure) ----
        $this->report = [
            'totals' => [
                'date_from' => $this->date_from,
                'date_to'   => $this->date_to,
                'total'     => $regs->count(),
            ],
            'country'      => $country,
            'attendeeType' => $attendeeType,
        ];

        // ---- CHART OUTPUT (same pattern as financial) ----
        $this->charts = [
            [
                'id'     => 'chart-attendeeType',
                'type'   => 'bar',
                'title'  => 'Medical attendeeType',
                'labels' => $attendeeType['labels'],
                'data'   => $attendeeType['counts'],
            ],
            [
                'id'     => 'chart-country',
                'type'   => 'bar',
                'title'  => 'Country',
                'labels' => $country['labels'],
                'data'   => $country['counts'],
            ],
        ];

        // Fire event for JS to re-render charts (same behaviour as financial)
        $this->dispatch('demographics-charts:update', charts: $this->charts);
    }

    /**
     * Count labels, produce % and raw counts
     */
    protected function tally(Collection $labels): array
    {
        $counts = [];

        foreach ($labels as $label) {
            $key = ($label === null || $label === '') ? 'Unspecified' : $label;
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }

        $labels_out = array_keys($counts);
        $counts_out = array_values($counts);
        $total      = max(1, array_sum($counts_out));

        $pct_out = array_map(
            fn ($c) => round(($c / $total) * 100, 1),
            $counts_out
        );

        return [
            'labels'      => $labels_out,
            'counts'      => $counts_out,
            'percentages' => $pct_out,
            'max'         => $counts_out ? max($counts_out) : 0,
        ];
    }

    /**
     * Sorts tally results by count desc
     */
    protected function sortTally(array $tally): array
    {
        $rows = [];

        foreach ($tally['labels'] as $i => $label) {
            $rows[] = [
                'label' => $label,
                'count' => $tally['counts'][$i] ?? 0,
                'pct'   => $tally['percentages'][$i] ?? 0,
            ];
        }

        usort($rows, fn ($a, $b) => $b['count'] <=> $a['count']);

        return [
            'labels'      => array_column($rows, 'label'),
            'counts'      => array_column($rows, 'count'),
            'percentages' => array_column($rows, 'pct'),
            'max'         => $rows ? max(array_column($rows, 'count')) : 0,
        ];
    }

    public function render()
    {
        return view('livewire.backend.admin.reports.demographics.view');
    }
}
