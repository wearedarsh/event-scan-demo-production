<?php

namespace App\Livewire\Backend\Admin\ManualCheckIn;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSession;
use App\Models\EventSessionGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class SelectSession extends Component
{
    public Event $event;
    public EventSessionGroup $group;

    public function mount(Event $event, EventSessionGroup $group)
    {
        $this->event = $event;
        $this->group  = $group;
    }

    public function render()
    {
        $sessions = EventSession::query()
            ->where('event_session_group_id', $this->group->id)
            ->orderBy('display_order')
            ->orderBy('start_time')
            ->get();

        return view('livewire.backend.admin.manual-check-in.select-session', [
            'event'   => $this->event,
            'group'    => $this->group,
            'sessions' => $sessions,
        ]);
    }
}
