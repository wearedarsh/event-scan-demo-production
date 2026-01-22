<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public function __construct(public string $token) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', ['token' => $this->token, 'email' => $notifiable->email]));

        return (new MailMessage)->from(
            client_setting('email.transactional.from_address'),
            client_setting('email.transactional.from_name')
        )
            ->subject('Reset your password')
            ->view('emails.auth.reset-password', [
                'url' => $resetUrl,
                'user' => $notifiable,
            ]);
    }
}
