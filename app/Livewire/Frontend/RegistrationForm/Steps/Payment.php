<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;

class Payment extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.payment');
    }
}
