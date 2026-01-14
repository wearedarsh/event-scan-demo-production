<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use App\Models\Event;

use Livewire\Component;

class BankTransferInformation extends Component
{
    public Event $event;
    public $step_help_info;

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.bank-transfer-information');
    }
}
