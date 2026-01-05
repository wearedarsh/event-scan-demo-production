<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Sichikawa\LaravelSendgridDriver\SendGrid;
use App\Models\ClientSetting;

class BroadcastEmail extends Mailable
{
    use SendGrid;

    public string $custom_subject;
    public string $html_content;
    public int $broadcast_id;
    public ?int $email_send_id;
    public ?string $client_id;

    public function __construct(
        string $custom_subject,
        string $html_content,
        int $broadcast_id,
        ?int $email_send_id = null,
        ?string $client_id = null
    ) {
        $this->custom_subject = $custom_subject;
        $this->html_content = $html_content;
        $this->broadcast_id = $broadcast_id;
        $this->email_send_id = $email_send_id;
        $this->client_id = $client_id;
    }

    public function envelope(): Envelope
    {
        $this->sendgrid([
            'custom_args' => [
                'client_id' => (string) $this->client_id,
                'email_send_id' => (string) $this->email_send_id,
            ],
        ]);

        return new Envelope(
            from: new Address(ClientSetting::get('from_address'), ClientSetting::get('from_name')),
            subject: $this->custom_subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.broadcast',
        );
    }
}
