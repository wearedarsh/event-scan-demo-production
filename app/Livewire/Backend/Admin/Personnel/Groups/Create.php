<?php

namespace App\Livewire\Backend\Admin\Personnel\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PersonnelGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;

    public string $title = '';
    public string $label_background_colour = '#000000';
    public string $label_colour = '#FFFFFF';

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'label_background_colour' => 'required|string',
            'label_colour' => 'required|string',
        ]);

        PersonnelGroup::create([
            'event_id' => $this->event->id,
            'title' => $this->title,
            'label_background_colour' => $this->label_background_colour,
            'label_colour' => $this->label_colour,
        ]);

        session()->flash('success', 'Personnel group created successfully.');
        return redirect()->route('admin.events.personnel.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.personnel.groups.create');
    }
}
