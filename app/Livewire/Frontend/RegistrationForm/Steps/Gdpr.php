<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use App\Models\RegistrationOptInResponse;
use Illuminate\Support\Facades\Auth;

class Gdpr extends Component
{
    public Event $event;
    public Registration $registration;
    public array $opt_in_responses = [];
    public $email_marketing_opt_in = false;

    protected $listeners = [
        'validate-step' => 'validateStep'
    ];

    public function mount(){
        foreach ($this->event->eventOptInChecks as $check) {
            $this->opt_in_responses[$check->id] = false;
        }
    }

    public function storeOptInResponses()
    {

        if($this->email_marketing_opt_in){
            if(Auth::check()){
                Auth::user()->update([
                    'email_marketing_opt_in' => $this->email_marketing_opt_in,
                ]);
            }
        }

        foreach ($this->opt_in_responses as $check_id => $value) {
            RegistrationOptInResponse::updateOrCreate([
                'registration_id' => $this->registration->id,
                'event_opt_in_check_id' => $check_id,
            ], [
                'value' => (bool) $value,
            ]);
        }
    }

    public function validateStep($direction){
        $this->dispatch('scroll-to-top');
        $this->storeOptInResponses();
        $this->dispatch('update-step', $direction);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.gdpr');
    }
}
