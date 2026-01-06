<?php

namespace App\Livewire\Backend\Admin\Attendees;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

use App\Exports\AttendeesPaymentDataExport;
use App\Exports\AttendeesSpecialRequirementsExport;
use Maatwebsite\Excel\Facades\Excel;


use App\Models\AttendeeGroup;


#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Event $event;
    public $currency_symbol;
    public $search = '';
    public $paymentMethod = '';
    public $groupFilter = '';
    public $ticketFilter = '';
    protected string $paginationTheme = 'bootstrap';
    public $groupSelections = [];
    public $groups = [];

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event)
    {

        $this->event = $event;
        $this->currency_symbol = client_setting('general.currency_symbol');
        $this->groups = $this->event->attendeeGroups()->orderBy('title')->get();

        foreach ($this->event->attendees as $a) {
            $this->groupSelections[$a->id] = $a->attendee_group_id;
        }
    }

    public function updateGroup($attendeeId, $groupId)
    {
        $attendee = Registration::find($attendeeId);

        if (! $attendee) return;

        $attendee->attendee_group_id = $groupId ?: null;
        $attendee->save();

        session()->flash('group', 'Group updated');
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportAttendees()
    {
        $filename = 'attendee-payment-data-' . date('d-m-Y') . '.xlsx';
        return Excel::download(new AttendeesPaymentDataExport($this->event), $filename);
    }

    public function exportAttendeeSpecialRequirements()
    {
        $filename = 'attendee-special-requirements-' . date('d-m-Y') . '.xlsx';
        return Excel::download(new AttendeesSpecialRequirementsExport($this->event), $filename);
    }

    public function updatingPaymentMethod()
    {
        $this->resetPage();
    }

    public function updatingGroupFilter()
    {
        $this->resetPage();
    }

    public function updatingTicketFilter()
    {
        $this->resetPage();
    }

    public function render()
{

    $attendees = $this->event->attendees()
        ->with(['user', 'country', 'eventPaymentMethod', 'attendeeGroup', 'registrationTickets'])
        ->where(function ($query) {
            $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$this->search}%"))
                ->orWhere('last_name', 'like', "%{$this->search}%");
        })
        ->when($this->paymentMethod, function ($query) {
            $query->whereHas('eventPaymentMethod', fn($q) => 
                $q->where('payment_method', $this->paymentMethod)
            );
        })
        ->when($this->groupFilter !== '', function ($query) {
            if ($this->groupFilter === 'none') {
                $query->whereNull('attendee_group_id');
            } else {
                $query->where('attendee_group_id', (int) $this->groupFilter);
            }
        })
        ->when($this->ticketFilter !== '', function ($query) {
            if ($this->ticketFilter === 'none') {
                $query->doesntHave('registrationTickets');
            } else {
                $query->whereHas('registrationTickets', fn($q) =>
                    $q->where('ticket_id', (int) $this->ticketFilter)
                );
            }
        })
        ->latest()
        ->paginate(10);

    $counts['all'] = $this->event->attendees()->count();


    $counts['payment_methods'] = [
        'stripe'       => $this->event->attendees()
                                ->whereHas('eventPaymentMethod', fn($q) => $q->where('payment_method', 'stripe'))
                                ->count(),
        'bank_transfer'         => $this->event->attendees()
                                ->whereHas('eventPaymentMethod', fn($q) => $q->where('payment_method', 'bank_transfer'))
                                ->count(),
    ];
    $counts['payment_methods']['all'] =
        array_sum($counts['payment_methods']);


    $groupCounts = [];
    foreach ($this->event->attendeeGroups as $group) {
        $groupCounts[$group->id] = $group->attendees()->count();
    }
    $groupCounts['none'] = $this->event->attendees()->whereNull('attendee_group_id')->count();
    $groupCounts['all'] = $counts['all'];
    $counts['groups'] = $groupCounts;


    $ticketCounts = [];
    foreach ($this->event->allTickets as $ticket) {
        $ticketCounts[$ticket->id] =
            $this->event->attendees()->whereHas('registrationTickets', fn($q) =>
                $q->where('ticket_id', $ticket->id)
            )->count();
    }
    $ticketCounts['none'] = $this->event->attendees()->doesntHave('registrationTickets')->count();
    $ticketCounts['all']  = $counts['all'];
    $counts['tickets'] = $ticketCounts;


    $attendee_groups = $this->event->attendeeGroups()
        ->withCount('attendees')
        ->paginate(5);

    $all_attendee_groups = $this->event->attendeeGroups()
        ->orderBy('title')
        ->get();

    $has_groups = $all_attendee_groups->isNotEmpty();

    $tickets = $this->event->allTickets()
        ->select('id', 'name', 'price')
        ->orderBy('ticket_group_id')
        ->orderBy('name')
        ->get();

    return view('livewire.backend.admin.attendees.index', compact(
        'attendees',
        'attendee_groups',
        'all_attendee_groups',
        'has_groups',
        'tickets',
        'counts'
    ));
}


    public function delete(int $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->user->update(['active' => false]);
        $registration->delete();
        $registration->user->delete();

        session()->flash('success', 'Attendee soft deleted successfully.');
    }

    public function deleteAttendeeGroup(int $id)
    {

        $attendee_group = AttendeeGroup::findOrFail($id);

        $attendee_group->delete();

        session()->flash('success', 'Attendee group deleted successfully.');
    }
}
