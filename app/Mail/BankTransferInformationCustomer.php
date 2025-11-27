<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;

class BankTransferInformationCustomer extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bank transfer payment instruction'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer.bank-transfer-information',
            with: [
                'registration' => $this->registration,
                'registration_total' => $this->registration_total,
                'currency_symbol' => '€',
                'title' => 'Thank you for choosing bank transfer',
                'preheader' => 'We have received your registration and bank transfer instructions follow below.',
            ]
        );
    }
}
