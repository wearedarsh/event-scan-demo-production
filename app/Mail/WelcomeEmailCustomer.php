<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;
use App\Models\ClientSetting;
use App\Models\EmailHtmlContent;

class WelcomeEmailCustomer extends Mailable
{
    public EmailHtmlContent $email_html_content;

    public function __construct(
        public Registration $registration
    ) {
        $this->email_html_content = EmailHtmlContent::where('key_name', 'customer_welcome_email')->first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to our events'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.welcome',
            with: [
                'email_signature' => ClientSetting::getValue('email', 'transactional_signature_html'),
                'registration' => $this->registration,
                'title' => 'Thank you for registering',
                'preheader' => 'We look forward to seeing you...',
                'email_html_content' => $this->email_html_content,
            ]
        );
    }
}
