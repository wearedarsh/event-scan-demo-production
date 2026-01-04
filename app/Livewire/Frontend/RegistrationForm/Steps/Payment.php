<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;

class Payment extends Component
{
    public Event $event;
    public Registration $registration;
    public $currency_symbol = '£';
    public int $registration_total = 0;

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount(){
        $this->calculateTotal();
    }

    public function calculateTotal(){
        $tickets = $this->registration->registrationTickets;

        foreach($tickets as $ticket){
            $ticket_total = $ticket->price_at_purchase * $ticket->quantity;
            $this->registration_total += $ticket_total;
        }

    }

    public function validateStep($direction){

        $this->dispatch('update-step', $direction);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.payment');
    }
}
