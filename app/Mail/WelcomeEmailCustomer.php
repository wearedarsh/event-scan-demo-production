<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\EventHtmlEmailContent;
use App\Models\EmailHtmlLayout;
use Illuminate\Support\Facades\Blade;

class WelcomeEmailCustomer extends Mailable
{
    public function __construct(
        public Registration $registration
    ) {}

    public function build(): static
    {
        $email_content = EventHtmlEmailContent::where('event_id', $this->registration->event_id)
            ->where('key_name', 'customer_welcome_email')
            ->firstOrFail();

        $layout = EmailHtmlLayout::where('key_name', 'customer')->firstOrFail();

        $email_signature = client_setting('email.customer.signature_html');

        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration,
            'event' => $this->registration->event,
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
