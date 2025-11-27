<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Registration;

class BankTransferConfirmationAdmin extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New registration - Bank transfer'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.bank-transfer-confirmation',
            with: [
                'registration' => $this->registration,
                'registration_total' => $this->registration_total,
                'currency_symbol' => '€',
                'title' => 'A registrant has opted to pay by bank transfer',
                'preheader' => 'The registration total is...',
            ]
        );
    }
}
