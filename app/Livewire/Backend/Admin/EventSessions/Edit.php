<?php

namespace App\Livewire\Backend\Admin\EventSessions;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSessionGroup;
use App\Models\EventSession;
use App\Models\EventSessionType;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public EventSessionGroup $group;
    public EventSession $event_session;

    public string $title;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public float $cme_points = 0.0;
    public int $event_session_type_id;
    public int $display_order = 0;
   

    public function mount(Event $event, EventSessionGroup $group, EventSession $event_session)
    {
        $this->event = $event;
        $this->group = $group;
        $this->event_session_type_id = $event_session->type->id;
        $this->event_session = $event_session;
        $this->title = $event_session->title;
        $this->start_time = $event_session->start_time;
        $this->end_time = $event_session->end_time;
        $this->cme_points = $event_session->cme_points;
        $this->display_order = $event_session->display_order;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'cme_points' => [
                'required',
                'numeric',
                'min:0',
                function ($attr, $value, $fail) {
                    if (fmod($value * 10, 5) !== 0.0) {
                        $fail('CME points must be in 0.5 increments.');
                    }
                }
            ],
            'event_session_type_id' => 'required|exists:event_session_types,id',
            'display_order' => 'nullable|integer',
        ],[
            'event_session_type_id.required' => 'Please select a session type',
        ]);


        $this->event_session->update([
            'title' => $this->title,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'cme_points' => $this->cme_points,
            'event_session_type_id' => $this->event_session_type_id,
            'event_session_group_id' => $this->group->id,
            'display_order' => $this->display_order,
        ]);

        session()->flash('success', 'Session edited successfully.');
        return redirect()->route('admin.events.event-sessions.manage', ['event' => $this->event->id, 'group' => $this->group->id]);
    }

    public function render()
    {
        $types = EventSessionType::where('active', true)->get();

        return view('livewire.backend.admin.event-sessions.edit', [
            'types' => $types
        ]);
    }
}
