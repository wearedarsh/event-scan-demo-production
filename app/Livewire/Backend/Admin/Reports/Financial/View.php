<?php

namespace App\Livewire\Backend\Admin\Reports\Financial;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Collection;

use App\Exports\AttendeesPaymentDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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
		if (in_array($prop, ['date_from','date_to'])) {
			$this->build_report();
		}
	}

	public function exportPayments(Event $event, Request $request)
	{
		$dateFrom = $request->query('date_from');
		$dateTo   = $request->query('date_to');

		return Excel::download(
			new AttendeesPaymentDataExport($event, $dateFrom, $dateTo, true),
			"payments-{$event->id}-{$dateFrom}-{$dateTo}.xlsx"
		);
	}
	
	protected function build_report(): void
    {
   
        $attendees = Registration::query()
            ->with(['eventPaymentMethod:id,name','registrationTickets.ticket:id,name,price'])
            ->where('event_id', $this->event->id)
            ->where('is_complete', true)
            ->paid()
            ->when($this->date_from, fn($q)=>$q->whereDate('paid_at','>=',$this->date_from))
            ->when($this->date_to,   fn($q)=>$q->whereDate('paid_at','<=',$this->date_to))
            ->get(['id','event_id','event_payment_method_id','registration_total','paid_at']);

        $registrations = Registration::query()
            ->where('event_id', $this->event->id)
            ->unpaidComplete() // payment_status='pending' AND is_complete=true
            ->when($this->date_from, fn($q)=>$q->whereDate('created_at','>=',$this->date_from))
            ->when($this->date_to,   fn($q)=>$q->whereDate('created_at','<=',$this->date_to))
            ->get(['id']);

        $totals = [
            'attendees'     => $attendees->count(),                                  // paid & complete
            'registrations' => $registrations->count(),                              // complete & unpaid
            'revenue'       => (float) $attendees->sum('registration_total'),        // paid only
            'date_from'     => $this->date_from,
            'date_to'       => $this->date_to,
        ];

        $tickets  = $this->tickets_breakdown($attendees);
        $payments = $this->payment_breakdown($attendees);

        $this->report = [
            'totals'   => $totals,
            'tickets'  => $tickets,
            'payments' => $payments,
        ];

        $this->charts = [
            ['id'=>'chart-tickets-count','type'=>'bar','title'=>'Tickets • quantity','labels'=>$tickets['labels'],'data'=>$tickets['counts']],
            ['id'=>'chart-tickets-value','type'=>'bar','title'=>'Tickets • value','labels'=>$tickets['labels'],'data'=>$tickets['totals']],
            ['id'=>'chart-payments-count','type'=>'bar','title'=>'Payment methods • count','labels'=>$payments['labels'],'data'=>$payments['counts']],
            ['id'=>'chart-payments-value','type'=>'bar','title'=>'Payment methods • value','labels'=>$payments['labels'],'data'=>$payments['totals']],
        ];

    	$this->dispatch('financial-charts:update', charts: $this->charts);
    }


	protected function tickets_breakdown(Collection $paid): array
	{
		$map = [];
		foreach ($paid as $r) {
			foreach ($r->registrationTickets as $rt) {
				$name = $rt->ticket->name ?? 'Unspecified';
				$qty  = (int) ($rt->quantity ?? 1);
				$line = $rt->line_total ?? ($rt->total ?? null);
				if ($line === null) {
					$unit = $rt->unit_price ?? $rt->price ?? $rt->ticket->price ?? 0;
					$line = (float) $unit * max(1, $qty);
				}
				$map[$name] = [
					'count' => ($map[$name]['count'] ?? 0) + max(1, $qty),
					'total' => ($map[$name]['total'] ?? 0) + (float) $line,
				];
			}
		}
		if (!$map) $map = ['Unspecified' => ['count'=>0,'total'=>0.0]];

		$rows = [];
		foreach ($map as $label => $v) {
			$rows[] = ['label'=>$label, 'count'=>$v['count'], 'total'=>round((float)$v['total'], 2)];
		}
		usort($rows, fn($a,$b) => $b['total'] <=> $a['total']);

		return [
			'labels' => array_column($rows, 'label'),
			'counts' => array_column($rows, 'count'),
			'totals' => array_column($rows, 'total'),
			'max_count' => $rows ? max(array_column($rows, 'count')) : 0,
			'max_total' => $rows ? max(array_column($rows, 'total')) : 0.0,
		];
	}

	protected function payment_breakdown(Collection $paid): array
	{
		$map = [];
		foreach ($paid as $r) {
			$label = $r->eventPaymentMethod->name ?? 'Unspecified';
			$map[$label] = [
				'count' => ($map[$label]['count'] ?? 0) + 1,
				'total' => ($map[$label]['total'] ?? 0) + (float) $r->registration_total,
			];
		}
		if (!$map) $map = ['Unspecified' => ['count'=>0,'total'=>0.0]];

		$rows = [];
		foreach ($map as $label => $v) {
			$rows[] = ['label'=>$label, 'count'=>$v['count'], 'total'=>round((float)$v['total'], 2)];
		}
		usort($rows, fn($a,$b) => $b['total'] <=> $a['total']);

		return [
			'labels' => array_column($rows, 'label'),
			'counts' => array_column($rows, 'count'),
			'totals' => array_column($rows, 'total'),
			'max_count' => $rows ? max(array_column($rows, 'count')) : 0,
			'max_total' => $rows ? max(array_column($rows, 'total')) : 0.0,
		];
	}

	public function render()
	{
		return view('livewire.backend.admin.reports.financial.view');
	}
}
