<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class CustomEmail extends Mailable
{
    use SendGrid;

    public function __construct(
        public string $custom_subject,
        public string $custom_html_content,
        public string $signature_html
    ) {}

    public function envelope(): Envelope
    {

        return new Envelope(
            from: new Address(config('mail.customer.address'), config('mail.customer.name')),
            subject: $this->custom_subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.custom-email',
            with: [
                'custom_html_content' => $this->custom_html_content,
                'signature_html' => $this->signature_html
            ]
        );
    }

}
