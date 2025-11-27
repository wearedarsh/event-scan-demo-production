<?php

namespace App\Livewire\Backend\Admin\Attendees;

use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailSignature;
use App\Services\EmailService;
use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;


#[Layout('livewire.backend.admin.layouts.app')]
class SendEmailAll extends Component
{
    public string $email = '';
    public string $custom_subject = '';
    public string $custom_html_content = '';
    public string $signature = '';
    public Event $event;

    public function mount(Event $event){
        $this->event = $event;
    }

    public function send()
    {

        $this->validate([
            'custom_subject' => 'required|string',
            'custom_html_content' => ['required', 'string', function ($attribute, $value, $fail) {
                $plainText = strip_tags($value);
                if (strlen(trim($plainText)) < 10) {
                    $fail('The ' . $attribute . ' must be at least 10 characters.');
                }
            }],
        ]);


        Log::info('System sending bulk custom email');

        $signature_html = $this->signature ? EmailSignature::find($this->signature)->html_content : '';

        $attendees = $this->event->attendees;

        foreach ($attendees as $attendee) {
            $mailable = new CustomEmail($this->custom_subject, $this->custom_html_content, $signature_html);

            EmailService::queueMailable(
                mailable: $mailable,
                recipient_user: $attendee->user,
                recipient_email: $attendee->user->email,
                sender_id: auth()->id(),
                friendly_name: 'Send to all attendees',
                type: 'Admin triggered',
                event_id: $this->event->id,
            );
        }

        session()->flash('success', 'Emails queued for sending.');
        return redirect()->route('admin.events.attendees.index', [
            'event' => $this->event->id
        ]);
    }


    public function render()
    {
        $signatures = EmailSignature::where('active', true)->get();
        return view('livewire.backend.admin.attendees.send-email-all',[
            'ck_apikey' => config('services.ckeditor.api_key'),
            'signatures' => $signatures,
        ]);
    }
}
