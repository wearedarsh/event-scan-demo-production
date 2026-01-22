<?php

namespace App\Livewire\Frontend\RegistrationForm\States;

use App\Models\Event;
use App\Models\RegistrationForm;
use App\Models\Registration;

use Livewire\Component;

class StripeCheckoutSuccess extends Component
{
    public Registration $registration;
    public RegistrationForm $registration_form;
    public Event $event;
    public $currency_symbol = '';

    public function mount(){
        $this->currency_symbol = client_setting('general.currency_symbol');

        dispatch('clear-session');
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.states.stripe-check-out-success');
    }
}
