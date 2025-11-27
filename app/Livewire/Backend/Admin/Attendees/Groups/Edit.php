<?php

namespace App\Livewire\Backend\Admin\Attendees\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AttendeeGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public AttendeeGroup $attendee_group;

    public string $title = '';
    public string $colour = '#000000';
    public string $label_colour = '#ffffff';

    public function mount(Event $event, AttendeeGroup $attendee_group)
    {
        $this->event = $event;
        $this->attendee_group = $attendee_group;

        $this->title = $attendee_group->title;
        $this->colour = $attendee_group->colour ?? '';
        $this->label_colour = $attendee_group->label_colour ?? '';
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'colour' => 'required|string',
            'label_colour' => 'required|string',
        ]);

        $this->attendee_group->update([
            'title' => $this->title,
            'colour' => $this->colour,
            'label_colour' => $this->label_colour,
        ]);

        session()->flash('success', 'Attendee group updated successfully.');
        return redirect()->route('admin.events.attendees.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.attendees.groups.edit');
    }
}
