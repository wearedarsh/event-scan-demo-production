<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use App\Services\RegistrationPaymentService;


class Payment extends Component
{
    public Event $event;
    public Registration $registration;
    public $currency_symbol = '';

    public $step_help_info;
    public $total_steps;
    public $current_step;

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount(){
        $this->currency_symbol = client_setting('general.currency_symbol');
    }

    public function validateStep($direction){

        $this->dispatch('update-step', $direction);
    }

    public function noPaymentDue(RegistrationPaymentService $service)
    {
        $service->completeFreeRegistration($this->registration);
        $this->dispatch('enter-system-state', 'no-charge-success');
    }

    public function bankTransferPayment(RegistrationPaymentService $service)
    {
        $service->initiateBankTransfer($this->registration);
        $this->dispatch('enter-system-state', 'bank-transfer-information');
    }

    public function stripePayment(RegistrationPaymentService $service)
    {
        $this->registration->load('registrationTickets.ticket');

        $this->registration->update([
            'last_intended_step' => $this->current_step
        ]);

        $url = $service->createStripeCheckoutSession($this->registration);

        return redirect($url);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.payment');
    }
}
