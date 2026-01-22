<?php

namespace App\Livewire\Frontend\RegistrationForm\States;

use App\Models\Event;
use App\Models\RegistrationForm;
use App\Models\RegistrationPayment;
use App\Models\Registration;
use Illuminate\Support\Facades\Session;

use Livewire\Component;

class StripePaymentPending extends Component
{
    public Registration $registration;
    public RegistrationForm $registration_form;
    public Event $event;
    public $currency_symbol = '';

    public function mount()
    {

        $this->registration->update([
            'registration_locked' => true
        ]);

        $this->dispatch('clear-session');
        
        $this->currency_symbol = client_setting('general.currency_symbol');
        
        $stripe_payment_confirmed = RegistrationPayment::where('registration_id', $this->registration->id)
            ->where('provider', 'stripe')
            ->where('status', 'paid');

        if($this->registration->payment_status === 'paid' && $stripe_payment_confirmed){
            $this->dispatch('enter-system-state', 'stripe-checkout-success');
        }
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.states.stripe-payment-pending');
    }
}
