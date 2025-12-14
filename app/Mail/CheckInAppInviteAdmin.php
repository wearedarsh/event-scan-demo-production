<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Blade;

class CheckInAppInviteAdmin extends Mailable
{
    public function __construct(
        public User $user,
        public string $reset_url
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'check_in_app_invite')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();
        $email_signature = ClientSetting::getValue('email', 'transactional_signature_html');

        $initialise_link =
            config('check-in-app.scheme')
            . '://initialise?client_id=' . config('services.eventscan.client_id')
            . '&auth_token=' . config('check-in-app.auth_token')
            . '&qr_prefix=' . config('check-in-app.qr_prefix');

        $body_html = Blade::render($email_content->html_content, [
            'user' => $this->user,
            'reset_url' => $this->reset_url,
            'initialise_link' => $initialise_link,
            'email_signature' => $email_signature,
        ]);

        $full_html = Blade::render($layout->html_content, [
            'title' => $email_content->subject,
            'pre_header' => $email_content->pre_header,
            'body_html_content' => $body_html,
            'app_url' => config('app.url'),
            'sub_title' => '',
        ]);

        return $this->subject($email_content->subject)
                    ->html($full_html);
    }
}
