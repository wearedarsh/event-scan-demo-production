<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use App\Models\Event;
use App\Models\RegistrationForm;
use App\Models\Registration;

use Livewire\Component;

class BankTransferInformation extends Component
{
    public Registration $registration;
    public RegistrationForm $registration_form;
    public Event $event;
    public $step_help_info;
    

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.bank-transfer-information');
    }
}
