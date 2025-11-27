<?php

namespace App\Livewire\Backend\Admin\ManualCheckIn;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSession;
use App\Models\Registration;
use App\Models\CheckIn;

#[Layout('livewire.backend.admin.layouts.app')]
class Guestlist extends Component
{
    public Event $event;
    public EventSession $session;

    public string $search = '';
    public array $checkedIn = [];

    public function mount(Event $event, EventSession $session)
    {
        $this->event  = $event;
        $this->session = $session;

        $this->checkedIn = CheckIn::query()
            ->where('event_id', $this->event->id)
            ->where('event_session_id', $this->session->id)
            ->pluck('id', 'attendee_id')
            ->all();
    }

    public function render()
    {
        $attendees = Registration::query()
            ->where('event_id', $this->event->id)
            ->paid()
            ->when($this->search !== '', function ($q) {
                $q->where('last_name', 'like', $this->search.'%');
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id','title','first_name','last_name']);

        $totals = [
            'total'      => Registration::where('event_id', $this->event->id)->paid()->count(),
            'checked_in' => count($this->checkedIn),
        ];

        return view('livewire.backend.admin.manual-check-in.guest-list', [
            'attendees' => $attendees,
            'totals'    => $totals,
        ]);
    }

    public function clearSearch(): void
    {
        $this->search = '';
    }

    public function toggleCheckIn(int $attendeeId): void
    {
        if (isset($this->checkedIn[$attendeeId])) {
            $id = $this->checkedIn[$attendeeId];
            CheckIn::where('id', $id)
                ->where('attendee_id', $attendeeId)
                ->where('event_id', $this->event->id)
                ->where('event_session_id', $this->session->id)
                ->delete();

            unset($this->checkedIn[$attendeeId]);
            $this->dispatch('toast', type: 'info', message: 'Check-in removed');
            return;
        }

        $res = app(\App\Services\CheckInService::class)->record(
            attendeeId:  $attendeeId,
            eventId:    $this->event->id,
            sessionId:   $this->session->id,
            byUserId:    auth()->id(),
            route:       'manual'
        );

        if (($res['status'] ?? 'error') === 'ok') {
            $this->checkedIn[$attendeeId] = $res['check_in']->id;
            $this->dispatch('toast', type: 'success', message: 'Checked in');
        } elseif ($res['status'] === 'duplicate') {
            $id = CheckIn::where([
                'attendee_id'      => $attendeeId,
                'event_id'        => $this->event->id,
                'event_session_id' => $this->session->id,
            ])->value('id');
            if ($id) $this->checkedIn[$attendeeId] = $id;
            $this->dispatch('toast', type: 'info', message: 'Already checked in');
        } else {
            $this->dispatch('toast', type: 'danger', message: 'Error recording check-in');
        }
    }
}
