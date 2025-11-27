<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReportDemographicsExportController extends Controller
{
	public function export(Event $event)
	{
		$regs = Registration::query()
			->with(['country:id,name','AttendeeType:id,name'])
			->where('event_id', $event->id)
			->paid()
			->get(['id','country_id','attendee_type_id','attendee_type_other']);

		$country = $this->sort_tally(
			$this->tally($regs->map(fn($r) => $r->country->name ?? 'Unspecified'))
		);

		$attendeeType = $this->sort_tally(
			$this->tally($regs->map(function ($r) {
				if ($r->AttendeeType?->name) return $r->AttendeeType->name;
				if ($r->attendee_type_other) return trim($r->attendee_type_other);
				return 'Unspecified';
			}))
		);

		$report = [
			'title' => 'Demographics Report',
			'country' => $country,
			'attendeeType' => $attendeeType,
			'total_attendees' => array_sum($country['counts']),
		];

		$pdf = Pdf::setOptions([
				'chroot' => base_path(),
				'isRemoteEnabled' => false,
				'enable_font_subsetting' => true,
			])
			->loadView('livewire.backend.admin.reports.demographics.exports.pdf', [
				'event'      => $event,
				'report'      => $report,
				'exported_at' => Carbon::now('Europe/London')->format('d/m/Y H:i'),
				'brand_color' => '#142B54',
				'logo_path'   => resource_path('brand/logo.jpg'),
			])
			->setPaper('a4', 'portrait');

		return $pdf->download('demographics-report-'.$event->id.'.pdf');
	}

	protected function tally(Collection $labels): array
	{
		$counts = [];
		foreach ($labels as $label) {
			$k = ($label === null || $label === '') ? 'Unspecified' : $label;
			$counts[$k] = ($counts[$k] ?? 0) + 1;
		}
		$labels_out = array_keys($counts);
		$counts_out = array_values($counts);
		$total = max(1, array_sum($counts_out));
		$pct_out = array_map(fn($c) => (int) round(($c / $total) * 100), $counts_out);

		return [
			'labels'      => $labels_out,
			'counts'      => $counts_out,
			'percentages' => $pct_out,
			'max'         => $counts_out ? max($counts_out) : 0,
		];
	}

	protected function sort_tally(array $tally): array
	{
		$rows = [];
		foreach ($tally['labels'] as $i => $label) {
			$rows[] = [
				'label' => $label,
				'count' => $tally['counts'][$i] ?? 0,
				'pct'   => $tally['percentages'][$i] ?? 0,
			];
		}
		usort($rows, fn($a,$b) => $b['count'] <=> $a['count']);

		return [
			'labels'      => array_column($rows, 'label'),
			'counts'      => array_column($rows, 'count'),
			'percentages' => array_column($rows, 'pct'),
			'max'         => $rows ? max(array_column($rows, 'count')) : 0,
		];
	}
}
