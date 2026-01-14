<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;

class ApprovalComplete extends Component
{
    public Event $event;
    public Registration $registration;
    public $step_help_info;

    protected $listeners = [
        'complete-approval-registration' => 'completeRegistration',
    ];

    public function completeRegistration()
    {
        
    }


    public function render()
    {
        return view('livewire.frontend.registration-form.steps.approval_complete');
    }
}
