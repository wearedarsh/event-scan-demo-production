<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;

class StripeConfirmationAdmin extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New registration - payment via Stripe'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.stripe-confirmation',
            with: [
                'registration' => $this->registration,
                'registration_total' => $this->registration_total,
                'currency_symbol' => '€',
                'title' => 'You have a new registration',
                'preheader' => '',
            ]
        );
    }
}
