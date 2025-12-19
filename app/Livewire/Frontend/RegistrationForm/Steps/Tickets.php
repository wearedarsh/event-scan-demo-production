<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;

class Tickets extends Component
{
    public Event $event;
    public $currency_symbol = '£';
    public $registration_total = 500;

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.tickets');
    }
}
