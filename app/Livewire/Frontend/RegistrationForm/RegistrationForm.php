<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\RegistrationFormStep;

#[Layout('livewire.frontend.registration.layouts.app')]
class RegistrationForm extends Component
{
    public Event $event;

    public int $step = 1;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function getCurrentStepProperty()
    {
        return RegistrationFormStep::query()
            ->orderBy('display_order')
            ->skip($this->step - 1)
            ->first();
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.parent', [
            'currentStep' => $this->currentStep,
        ]);
    }
}
