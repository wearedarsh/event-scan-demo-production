<?php

namespace Database\Seeders\Email;

use Illuminate\Database\Seeder;
use App\Models\EmailHtmlContent;

class EmailHtmlContentSeeder extends Seeder
{
    public function run(): void
    {
        // Admin emails
        EmailHtmlContent::insert([
            [
                'label' => 'Admin bank transfer notification',
                'key_name' => 'admin_bank_transfer_confirmation',
                'category' => 'admin',
                'subject' => 'New registration - Bank transfer',
                'pre_header' => 'A new registration has been made and payment will be made by bank transfer.',
                'html_content' => file_get_contents(resource_path('views/emails/admin/bank-transfer-confirmation.blade.php')),
            ],
            [
                'label' => 'Check in app instruction',
                'key_name' => 'check_in_app_instruction',
                'category' => 'admin',
                'subject' => 'Check-in App Instructions',
                'pre_header' => 'Instructions on how to use the event check-in app.',
                'html_content' => file_get_contents(resource_path('views/emails/admin/check-in-app-instruction.blade.php')),
            ],
            [
                'label' => 'Check in app invite',
                'key_name' => 'check_in_app_invite',
                'category' => 'admin',
                'subject' => 'You have been invited to the Check-in App',
                'pre_header' => 'You have been granted access to the event check-in app.',
                'html_content' => file_get_contents(resource_path('views/emails/admin/check-in-app-invite.blade.php')),
            ],
            [
                'label' => 'Admin no payment confirmation',
                'key_name' => 'admin_no_payment_confirmation',
                'category' => 'admin',
                'subject' => 'Registration without payment received',
                'pre_header' => 'A new registration has been completed with no payment required.',
                'html_content' => file_get_contents(resource_path('views/emails/admin/no-payment-confirmation.blade.php')),
            ],
            [
                'label' => 'Admin stripe confirmation',
                'key_name' => 'admin_stripe_confirmation',
                'category' => 'admin',
                'subject' => 'New registration - Stripe payment',
                'pre_header' => 'A new registration has been completed and payment was received via Stripe.',
                'html_content' => file_get_contents(resource_path('views/emails/admin/stripe-confirmation.blade.php')),
            ],
            [
                'label' => 'Admin approval registration complete confirmation',
                'key_name' => 'admin_registration_complete_confirmation',
                'category' => 'admin',
                'subject' => 'New registration - Pending approval',
                'pre_header' => 'A new registration has been completed for approval',
                'html_content' => file_get_contents(resource_path('views/emails/admin/approval-registration-complete-confirmation.blade.php')),
            ],
        ]);

        // Customer emails
        EmailHtmlContent::insert([
            [
                'label' => 'Customer bank transfer confirmation',
                'key_name' => 'customer_bank_transfer_confirmation',
                'category' => 'customer',
                'subject' => 'Your booking has been received',
                'pre_header' => 'Your registration is complete and we are awaiting your bank transfer.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/bank-transfer-confirmation.blade.php')),
            ],
            [
                'label' => 'Customer bank transfer information',
                'key_name' => 'customer_bank_transfer_information',
                'category' => 'customer',
                'subject' => 'Bank transfer payment instructions',
                'pre_header' => 'Here are the details you need to complete your bank transfer.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/bank-transfer-information.blade.php')),
            ],
            [
                'label' => 'Customer certificate confirmation',
                'key_name' => 'customer_certificate_confirmation',
                'category' => 'customer',
                'subject' => 'Your certificate of attendance',
                'pre_header' => 'Your certificate of attendance is ready to view or download.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/certificate-of-attendance-confirmation.blade.php')),
            ],
            [
                'label' => 'Customer no payment confirmation',
                'key_name' => 'customer_no_payment_confirmation',
                'category' => 'customer',
                'subject' => 'Thank you for your booking',
                'pre_header' => 'Your booking is confirmed and no payment was required.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/no-payment-confirmation.blade.php')),
            ],
            [
                'label' => 'Customer Stripe confirmation',
                'key_name' => 'customer_stripe_confirmation',
                'category' => 'customer',
                'subject' => 'Payment confirmation - Thank you for your booking',
                'pre_header' => 'Your payment was successful and your booking is confirmed.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/stripe-confirmation.blade.php')),
            ],
            [
                'label' => 'Customer approval registration complete confirmation',
                'key_name' => 'customer_registration_complete_confirmation',
                'category' => 'customer',
                'subject' => 'Registration complete - Pending approval',
                'pre_header' => 'Thank you for your application for this event',
                'html_content' => file_get_contents(resource_path('views/emails/customer/approval-registration-complete-confirmation.blade.php')),
            ],
        ]);
    }
}
