<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use App\Models\ClientSetting;
use Illuminate\Support\Facades\Blade;

class BankTransferConfirmationAdmin extends Mailable
{
    public function __construct(
        public Registration $registration,
        public float $registration_total
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'admin_bank_transfer_confirmation')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();
        $email_signature = ClientSetting::getValue('email', 'transactional_signature_html');


        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration,
            'registration_total' => $this->registration_total,
            'currency_symbol' => '€',
            'email_signature' => $email_signature,
        ]);

        $full_html = Blade::render($layout->html_content, [
            'title' => $email_content->subject,
            'pre_header' => $email_content->pre_header,
            'body_html_content' => $body_html,
            'app_url' => config('app.url'),
            'sub_title' => config('customer.contact_details.booking_website_company_name') . ' events',
        ]);

        return $this->subject($email_content->subject)
                    ->html($full_html);
    }
}
