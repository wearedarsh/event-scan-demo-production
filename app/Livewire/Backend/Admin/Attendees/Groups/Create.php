<?php

namespace App\Livewire\Backend\Admin\Attendees\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AttendeeGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;

    public string $title = '';
    public string $colour = '#000000'; 
    public string $label_colour = '#ffffff'; 

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'colour' => 'required|string',
            'label_colour' => 'required|string',
        ]);

        AttendeeGroup::create([
            'event_id' => $this->event->id,
            'title' => $this->title,
            'colour' => $this->colour,
            'label_colour' => $this->label_colour,
        ]);

        session()->flash('success', 'Attendee group created successfully.');
        return redirect()->route('admin.events.attendees.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.attendees.groups.create');
    }
}
