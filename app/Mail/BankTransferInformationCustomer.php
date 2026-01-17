<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use Illuminate\Support\Facades\Blade;

class BankTransferInformationCustomer extends Mailable
{
    public function __construct(
        public Registration $registration
    ) {}

    public function build(): static
    {
        $email_content = EmailHtmlContent::where('key_name', 'customer_bank_transfer_information')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'customer')->firstOrFail();
        $email_signature = client_setting('email.customer.signature_html');
        $currency_symbol = client_setting('general.currency_symbol');

        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration,
            'registration_total' => $this->registration->calculated_total,
            'currency_symbol' => $currency_symbol,
            'email_signature' => $email_signature
        ]);

        $full_html = Blade::render($layout->html_content, [
            'title' => $email_content->subject,
            'pre_header' => $email_content->pre_header,
            'body_html_content' => $body_html,
            'app_url' => config('app.url'),
        ]);

        return $this->subject($email_content->subject)
                    ->html($full_html);
    }
}
