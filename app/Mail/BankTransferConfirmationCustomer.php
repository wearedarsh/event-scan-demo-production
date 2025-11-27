<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;

class BankTransferConfirmationCustomer extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your EVF HOW event booking'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.bank-transfer-confirmation',
            with: [
                'registration' => $this->registration,
                'registration_total' => $this->registration_total,
                'currency_symbol' => '€',
                'title' => 'Thank you for your EVF HOW event booking',
                'preheader' => 'We look forward to seeing you at...',
            ]
        );
    }
}
