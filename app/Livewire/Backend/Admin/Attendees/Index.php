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

    #[Computed]
    public function roleKey(): string
    {
        return auth()->user()->role->key_name ?? '';
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->currency_symbol = config('app.currency_symbol', '€');
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
            ->with(['user','country','eventPaymentMethod','attendeeGroup', 'registrationTickets'])
            ->where(function($query) {
                $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$this->search}%"))
                    ->orWhere('last_name', 'like', "%{$this->search}%");
            })
            ->when($this->paymentMethod, function ($query) {
                $query->whereHas('eventPaymentMethod', fn($q) => $q->where('payment_method', $this->paymentMethod));
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

        $attendee_groups = $this->event->attendeeGroups()
            ->withCount('attendees')
            ->paginate(5);

        $all_attendee_groups = $this->event->attendeeGroups()->get()
            ->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $has_groups = $all_attendee_groups->isNotEmpty();

        $tickets = $this->event->allTickets()
            ->select('id','name', 'price')
            ->orderBy('ticket_group_id')
            ->orderBy('name')
            ->get();

        return view('livewire.backend.admin.attendees.index', compact(
            'attendees', 'attendee_groups', 'all_attendee_groups', 'has_groups', 'tickets'
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