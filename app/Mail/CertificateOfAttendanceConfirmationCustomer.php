<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\User;
use App\Models\FeedbackForm;
use App\Models\Registration;

class CertificateOfAttendanceConfirmationCustomer extends Mailable
{
    public function __construct(
        public User $user,
        public FeedbackForm $feedback_form,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your certificate of attendance for {$this->feedback_form->event->title}"
        );
    }

    public function content(): Content
    {
        $registration = Registration::where('user_id', $this->user->id)
            ->where('event_id', $this->feedback_form->event_id)
            ->latest()
            ->first();

        $url = route('customer.bookings.index', ['user' => $this->user->id]);

        return new Content(
            view: 'emails.customer.certificate-of-attendance-confirmation',
            with: [
                'user' => $this->user,
                'evaluation_form_title' => $this->feedback_form->title,
                'event_title' => $this->feedback_form->event->title,
                'url' => $url,
                'currency_symbol' => '€',
                'title' => 'Thank you for completing your evaluation form',
                'preheader' => 'You are now able to download your certificate of attendance...',
            ]
        );
    }
}
