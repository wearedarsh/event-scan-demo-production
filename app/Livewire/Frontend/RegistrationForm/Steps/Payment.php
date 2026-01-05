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
    public $currency_symbol = '[£]';
    public int $registration_total_cents = 0;
    public $registration_total = 0;

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount(){
        $this->registration_total = $this->registration->total;
        $this->registration_total_cents = $this->registration->total_cents;
    }

    public function validateStep($direction){

        $this->dispatch('update-step', $direction);
    }

    public function noPaymentDue(RegistrationPaymentService $service)
    {
        $service->completeFreeRegistration($this->registration);

        return redirect()->route('checkout.success', [
            'registration_id' => $this->registration->id,
            'event' => $this->registration->event,
        ]);
    }

    public function bankTransferPayment(RegistrationPaymentService $service)
    {
        $service->initiateBankTransfer($this->registration);

        $this->dispatch('update-step', 'complete');
    }

    public function stripePayment(RegistrationPaymentService $service)
    {
        $this->registration->load('registrationTickets.ticket');

        $url = $service->createStripeCheckoutSession($this->registration);

        return redirect($url);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.payment');
    }
}
