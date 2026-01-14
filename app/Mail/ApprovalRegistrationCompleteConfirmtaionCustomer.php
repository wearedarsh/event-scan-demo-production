<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Blade;

class ApprovalRegistrationCompleteConfirmationCustomer extends Mailable
{
    public function __construct(
        public Registration $registration
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'customer_registration_complete_confirmation')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();
        $email_signature = ClientSetting::get('transactional_signature_html');

        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration,
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
