<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;
use App\Models\FeedbackForm;
use App\Models\Registration;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Blade;

class CertificateOfAttendanceConfirmationCustomer extends Mailable
{
    public function __construct(
        public User $user,
        public FeedbackForm $feedback_form,
    ) {}

    public function build(): static
    {
        $registration = Registration::where('user_id', $this->user->id)
            ->where('event_id', $this->feedback_form->event_id)
            ->latest()
            ->first();

        $url = route('customer.bookings.index', ['user' => $this->user->id]);

        $email_content = EmailHtmlContent::where('key_name', 'customer_certificate_confirmation')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'customer')->firstOrFail();
        $email_signature = ClientSetting::getValue('email', 'transactional_signature_html');

        $body_html = Blade::render($email_content->html_content, [
            'user' => $this->user,
            'registration' => $registration,
            'feedback_form' => $this->feedback_form,
            'evaluation_form_title' => $this->feedback_form->title,
            'event_title' => $this->feedback_form->event->title,
            'url' => $url,
            'currency_symbol' => '€',
            'email_signature' => $email_signature,
        ]);

        $full_html = Blade::render($layout->html_content, [
            'title' => $email_content->subject,
            'pre_header' => $email_content->pre_header,
            'body_html_content' => $body_html,
            'app_url' => config('app.url'),
            'sub_title' => '',
        ]);

        return $this->subject($email_content->subject)
                    ->html($full_html);
    }
}
