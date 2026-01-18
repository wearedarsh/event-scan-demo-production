<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\Registration;
use App\Models\RegistrationPayment;
use App\Models\EmailHtmlContent;
use App\Models\EmailHtmlLayout;
use Illuminate\Support\Facades\Blade;

class StripeConfirmationAdmin extends Mailable
{
    public function __construct(
        public Registration $registration
    ) {}

    public function build(): static
    {
        $stripe_payment = RegistrationPayment::where('registration_id', $this->registration->id)
            ->where('provider', 'stripe')
            ->where('status', 'paid')
            ->firstOrFail();

        
        $email_content = EmailHtmlContent::where('key_name', 'admin_stripe_confirmation')->firstOrFail();
        $layout = EmailHtmlLayout::where('key_name', 'admin')->firstOrFail();

        $body_html = Blade::render($email_content->html_content, [
            'registration' => $this->registration,
            'registration_total' => $this->registration->calculated_total,
            'registration_payment' => $stripe_payment,
            'currency_symbol' => client_setting('general.currency_symbol')
        ]);

        $full_html = Blade::render($layout->html_content, [
            'title' => $email_content->subject,
            'pre_header' => $email_content->pre_header,
            'body_html_content' => $body_html,
            'app_url' => config('app.url')
        ]);

        return $this->subject($email_content->subject)
                    ->html($full_html);
    }
}
