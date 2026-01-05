<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Blade;

class CheckInAppInstructionAdmin extends Mailable
{
    public function __construct(
        public User $user
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'check_in_app_instruction')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();
        $email_signature = ClientSetting::get('transactional_signature_html');

        $initialise_link =
            client_setting('check_in_app.scheme')
            . '://initialise?client_id=' . config('api.client_id')
            . '&auth_token=' . config('check-in-app.auth_token')
            . '&qr_prefix=' . client_setting('check_in_app.qr_prefix');

        $body_html = Blade::render($email_content->html_content, [
            'user' => $this->user,
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
