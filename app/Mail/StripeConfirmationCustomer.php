<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;
use App\Models\ClientSetting;

class StripeConfirmationCustomer extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your event booking'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.stripe-confirmation',
            with: [
                'email_signature' => ClientSetting::getValue('email', 'transactional_signature_html'),
                'registration' => $this->registration,
                'registration_total' => $this->registration_total,
                'currency_symbol' => '€',
                'title' => 'Thank you for your event booking',
                'preheader' => 'We look forward to seeing you at...',
            ]
        );
    }
}
