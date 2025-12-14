<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailHtmlContent;
use Illuminate\Support\Facades\DB;

class EmailHtmlContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Admin emails
        EmailHtmlContent::insert([
            [
                'label' => 'Admin bank transfer notification',
                'key_name' => 'admin_bank_transfer_confirmation',
                'category' => 'admin',
                'subject' => 'New registration - Bank transfer',
                'html_content' => file_get_contents(resource_path('views/emails/admin/bank-transfer-confirmation.blade.php'))
            ],
            [
                'label' => 'Check in app instruction',
                'key_name' => 'check_in_app_instruction',
                'category' => 'admin',
                'subject' => 'Check-in App Instructions',
                'html_content' => file_get_contents(resource_path('views/emails/admin/check-in-app-instruction.blade.php'))
            ],
            [
                'label' => 'Check in app invite',
                'key_name' => 'check_in_app_invite',
                'category' => 'admin',
                'subject' => 'You have been invited to the Check-in App',
                'html_content' => file_get_contents(resource_path('views/emails/admin/check-in-app-invite.blade.php'))
            ],
            [
                'label' => 'Admin no payment confirmation',
                'key_name' => 'admin_no_payment_confirmation',
                'category' => 'admin',
                'subject' => 'Registration without payment received',
                'html_content' => file_get_contents(resource_path('views/emails/admin/no-payment-confirmation.blade.php'))
            ],
            [
                'label' => 'Admin stripe confirmation',
                'key_name' => 'admin_stripe_confirmation',
                'category' => 'admin',
                'subject' => 'New registration - Stripe payment',
                'html_content' => file_get_contents(resource_path('views/emails/admin/stripe-confirmation.blade.php'))
            ],
        ]);

        // Customer emails
        EmailHtmlContent::insert([
            [
                'label' => 'Customer bank transfer confirmation',
                'key_name' => 'customer_bank_transfer_confirmation',
                'category' => 'customer',
                'subject' => 'Your booking has been received',
                'html_content' => file_get_contents(resource_path('views/emails/customer/bank-transfer-confirmation.blade.php'))
            ],
            [
                'label' => 'Customer bank transfer information',
                'key_name' => 'customer_bank_transfer_information',
                'category' => 'customer',
                'subject' => 'Bank transfer payment instructions',
                'html_content' => file_get_contents(resource_path('views/emails/customer/bank-transfer-information.blade.php'))
            ],
            [
                'label' => 'Customer certificate confirmation',
                'key_name' => 'customer_certificate_confirmation',
                'category' => 'customer',
                'subject' => 'Your certificate of attendance',
                'html_content' => file_get_contents(resource_path('views/emails/customer/certificate-of-attendance-confirmation.blade.php'))
            ],
            [
                'label' => 'No payment confirmation',
                'key_name' => 'customer_no_payment_confirmation',
                'category' => 'customer',
                'subject' => 'Thank you for your booking',
                'html_content' => file_get_contents(resource_path('views/emails/customer/no-payment-confirmation.blade.php'))
            ],
            [
                'label' => 'Stripe confirmation',
                'key_name' => 'customer_stripe_confirmation',
                'category' => 'customer',
                'subject' => 'Payment confirmation - Thank you for your booking',
                'html_content' => file_get_contents(resource_path('views/emails/customer/stripe-confirmation.blade.php'))
            ],
        ]);
    }
}
