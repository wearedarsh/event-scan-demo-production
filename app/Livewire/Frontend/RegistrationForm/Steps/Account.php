<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;

class Account extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.account');
    }
}
