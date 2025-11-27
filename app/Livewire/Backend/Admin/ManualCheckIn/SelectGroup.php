<?php

namespace App\Livewire\Backend\Admin\ManualCheckIn;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventSessionGroup;

#[Layout('livewire.backend.admin.layouts.app')]
class SelectGroup extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        $groups = EventSessionGroup::where('event_id', $this->event->id)
            ->orderBy('display_order')
            ->get();

        return view('livewire.backend.admin.manual-check-in.select-group', [
            'event' => $this->event,
            'groups' => $groups,
        ]);
    }
}
