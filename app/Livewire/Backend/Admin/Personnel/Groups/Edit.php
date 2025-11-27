<?php

namespace App\Livewire\Backend\Admin\Personnel\Groups;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PersonnelGroup;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public PersonnelGroup $personnel_group;

    public string $title;
    public string $label_background_colour;
    public string $label_colour;

    public function mount(Event $event, PersonnelGroup $personnel_group)
    {
        $this->event = $event;
        $this->personnel_group = $personnel_group;

        $this->title = $personnel_group->title;
        $this->label_background_colour = $personnel_group->label_background_colour;
        $this->label_colour = $personnel_group->label_colour;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'label_background_colour' => 'required|string',
            'label_colour' => 'required|string',
        ]);

        $this->personnel_group->update([
            'title' => $this->title,
            'label_background_colour' => $this->label_background_colour,
            'label_colour' => $this->label_colour,
        ]);

        session()->flash('success', 'Personnel group updated successfully.');
        return redirect()->route('admin.events.personnel.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.personnel.groups.edit');
    }
}
