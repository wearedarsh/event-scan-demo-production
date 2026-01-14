<?php

namespace App\Livewire\Backend\Admin\Events;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\RegistrationPayment;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public Event $event;
    public $registrations_paid;
    public $registrations_unpaid;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->registrations_paid = RegistrationPayment::paid()
            ->whereHas('registration', fn ($q) =>
                $q->where('event_id', $this->event->id)
            )
            ->count();
        $this->registrations_paid = RegistrationPayment::paid()
            ->whereHas('registration', fn ($q) =>
                $q->where('event_id', $this->event->id)
            )
            ->count();

    }

    public function toggleActive()
    {
        $this->event->active = ! $this->event->active;
        $this->event->save();

        session()->flash('success', 'Event status updated.');
    }

    public function render()
    {
        return view('livewire.backend.admin.events.manage');
    }
}
