<?php

namespace App\Livewire\Backend\Admin\Emails;

use App\Mail\CustomEmail;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EmailSignature;
use App\Services\EmailService;
use App\Models\User;

#[Layout('livewire.backend.admin.layouts.app')]
class SingleSend extends Component
{
    public string $email = '';
    public string $custom_subject = '';
    public string $custom_html_content = '';
    public string $signature = '';

    public function send()
    {
        Log::info('System sending custom email');
        $signature_html = $this->signature ? EmailSignature::find($this->signature)->html_content : '';
        $mailable = new CustomEmail($this->custom_subject, $this->custom_html_content, $signature_html);

        $user = User::find(1);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_user: $user,
            recipient_email: $this->email,
            friendly_name: 'Single send',
            type: 'Test',
            event_id: 1,
        );

        session()->flash('success', 'Email sent successfully.');
    }

    public function render()
    {
        $signatures = EmailSignature::where('active', true)->get();
        return view('livewire.backend.admin.emails.single-send',[
            'ck_apikey' => config('services.ckeditor.api_key'),
            'signatures' => $signatures
        ]);
    }
}
