<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ReportFinancialExportController extends Controller
{
	public function export(Event $event, Request $request)
	{
		$date_from = $request->query('date_from');
		$date_to   = $request->query('date_to');

		$exportedAt = Carbon::now('Europe/London')->format('d/m/Y H:i');

		$dateFromUk = !empty($date_from)
			? Carbon::parse($date_from, 'UTC')->tz('Europe/London')->format('d/m/Y')
			: null;
		$dateToUk = !empty($date_to)
			? Carbon::parse($date_to, 'UTC')->tz('Europe/London')->format('d/m/Y')
			: null;

		$attendees = Registration::query()
			->with(['eventPaymentMethod:id,name','registrationTickets.ticket:id,name,price'])
			->where('event_id', $event->id)
			->where('is_complete', true)
			->paid()
			->when($date_from, fn($q)=>$q->whereDate('paid_at','>=',$date_from))
			->when($date_to,   fn($q)=>$q->whereDate('paid_at','<=',$date_to))
			->get(['id','event_id','event_payment_method_id','registration_total','paid_at']);

		$registrations = Registration::query()
			->where('event_id', $event->id)
			->where('is_complete', true)
			->where('payment_status','pending')
			->when($date_from, fn($q)=>$q->whereDate('created_at','>=',$date_from))
			->when($date_to,   fn($q)=>$q->whereDate('created_at','<=',$date_to))
			->get(['id']);

		$totals = [
			'attendees'     => $attendees->count(),
			'registrations' => $registrations->count(),
			'revenue'       => (float) $attendees->sum('registration_total'),
			'date_from'     => $date_from,
			'date_to'       => $date_to,
		];

		$tickets  = $this->tickets_breakdown($attendees);
		$payments = $this->payment_breakdown($attendees);

		$report = [
			'title'   => 'Financial Report',
			'totals'  => $totals,
			'tickets' => $tickets,
			'payments'=> $payments,
		];

		$pdf = Pdf::setOptions([
				'chroot' => base_path(),
				'isRemoteEnabled' => false,
				'enable_font_subsetting' => true,
			])
			->loadView('livewire.backend.admin.reports.financial.exports.pdf', [
				'event'      => $event,
				'report'      => $report,
				'brand_color' => '#142B54',
				'logo_path'   => resource_path('brand/logo.png'),
				'exported_at'  => $exportedAt,
    			'date_from_uk' => $dateFromUk,
    			'date_to_uk'   => $dateToUk,
			])
			->setPaper('a4', 'portrait');

		return $pdf->download('financial-report-'.$event->id.'.pdf');
	}

	protected function tickets_breakdown(Collection $attendees): array
	{
		$map = [];
		foreach ($attendees as $r) {
			foreach ($r->registrationTickets as $rt) {
				$label = $rt->ticket->name ?? 'Unspecified';
				$qty = (int) ($rt->quantity ?? 1);
				$line = $rt->line_total ?? ($rt->total ?? null);
				if ($line === null) {
					$unit = $rt->unit_price ?? $rt->price ?? $rt->ticket->price ?? 0;
					$line = (float) $unit * max(1, $qty);
				}
				$map[$label] = [
					'count' => ($map[$label]['count'] ?? 0) + max(1, $qty),
					'total' => ($map[$label]['total'] ?? 0) + (float) $line,
				];
			}
		}
		if (!$map) $map = ['Unspecified' => ['count'=>0,'total'=>0.0]];

		$rows = [];
		foreach ($map as $label => $v) $rows[] = ['label'=>$label,'count'=>$v['count'],'total'=>round((float)$v['total'],2)];
		usort($rows, fn($a,$b) => $b['total'] <=> $a['total']);

		$sum_total = array_sum(array_column($rows,'total')) ?: 1;
		$pcts = array_map(fn($v)=> (int) round(($v['total']/$sum_total)*100), $rows);

		return [
			'labels' => array_column($rows, 'label'),
			'counts' => array_column($rows, 'count'),
			'totals' => array_column($rows, 'total'),
			'percentages' => $pcts,
		];
	}

	protected function payment_breakdown(Collection $attendees): array
	{
		$map = [];
		foreach ($attendees as $r) {
			$label = $r->eventPaymentMethod->name ?? 'Unspecified';
			$map[$label] = [
				'count' => ($map[$label]['count'] ?? 0) + 1,
				'total' => ($map[$label]['total'] ?? 0) + (float) $r->registration_total,
			];
		}
		if (!$map) $map = ['Unspecified' => ['count'=>0,'total'=>0.0]];

		$rows = [];
		foreach ($map as $label => $v) $rows[] = ['label'=>$label,'count'=>$v['count'],'total'=>round((float)$v['total'],2)];
		usort($rows, fn($a,$b) => $b['total'] <=> $a['total']);

		$sum_total = array_sum(array_column($rows,'total')) ?: 1;
		$pcts = array_map(fn($v)=> (int) round(($v['total']/$sum_total)*100), $rows);

		return [
			'labels' => array_column($rows, 'label'),
			'counts' => array_column($rows, 'count'),
			'totals' => array_column($rows, 'total'),
			'percentages' => $pcts,
		];
	}
}
