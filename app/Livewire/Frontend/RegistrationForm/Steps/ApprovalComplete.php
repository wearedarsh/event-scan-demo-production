<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use App\Mail\ApprovalRegistrationCompleteConfirmationAdmin;
use App\Mail\ApprovalRegistrationCompleteConfirmationCustomer;
use App\Services\EmailService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ApprovalComplete extends Component
{
    public Event $event;
    public Registration $registration;
    public $step_help_info;

    public function mount()
    {

        if (! $this->registration) {
            return;
        }

        if ($this->registration->status === 'pending_approval') {
            return;
        }
        
        if($this->registration){
            $this->registration->update([
                'registration_status' => 'pending_approval'
            ]);
        }

        $mailable = new ApprovalRegistrationCompleteConfirmationAdmin($this->registration);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_user: $this->registration->user,
            recipient_email: $this->registration->user->email,
            friendly_name: 'Approval registration complete confirmation admin',
            type: 'transactional_admin',
            event_id: $this->registration->event_id,
        );

        $mailable = new ApprovalRegistrationCompleteConfirmationCustomer($this->registration);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_user: $this->registration->user,
            recipient_email: $this->registration->user->email,
            friendly_name: 'Approval registration complete confirmation customer',
            type: 'transactional_customer',
            event_id: $this->registration->event_id,
        );

        Auth::logout();
        Session::forget('registration_id');
    }


    public function render()
    {
        return view('livewire.frontend.registration-form.steps.approval_complete');
    }
}
