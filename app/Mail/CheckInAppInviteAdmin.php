<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\User;

class CheckInAppInviteAdmin extends Mailable
{
    public User $user;
    public string $qr_prefix;
    public string $client_id;
    public string $auth_token;
    public string $app_scheme;
    public string $reset_url;

    public function __construct(User $user, string $reset_url)
    {
        $this->user = $user;
        $this->reset_url = $reset_url;

        $this->qr_prefix = config('check-in-app.qr_prefix');
        $this->client_id = config('services.eventscan.client_id');
        $this->auth_token = config('check-in-app.auth_token');
        $this->app_scheme = config('check-in-app.scheme');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to use the ' . config('check-in-app.friendly_name') . ' app'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.check-in-app-invite',
            with: [
                'initialise_link' => $this->app_scheme.'://initialise?client_id='.$this->client_id.'&auth_token='.$this->auth_token.'&qr_prefix='.$this->qr_prefix,
                'user' => $this->user,
                'reset_url' => $this->reset_url,
            ]
        );
    }
}
