<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;

class Dynamic extends Component
{
    public Event $event;
    public RegistrationFormStep $registration_form_step;
    public $inputs;

    public function mount(){
        if($this->registration_form_step){
            $this->inputs = $this->registration_form_step->inputs;
        }
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.dynamic');
    }
}
