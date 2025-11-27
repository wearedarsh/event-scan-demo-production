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
            config('mail.transactional.address'),
            config('mail.transactional.name')
        )
            ->subject('Reset your EVF HOW password')
            ->view('emails.auth.reset-password', [
                'url' => $resetUrl,
                'user' => $notifiable,
            ]);
    }
}
