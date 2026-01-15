<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use Illuminate\Support\Facades\Blade;

class ApprovalRegistrationCompleteConfirmationAdmin extends Mailable
{
    public function __construct(
        public Registration $registration
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'admin_registration_complete_confirmation')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();

        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration
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
