<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingPaymentSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 7,
                'key_name'      => 'payment.bank_transfer.information.bank_details_html',
                'label'         => 'Bank transfer details html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<p><strong>Bank:</strong> Medical Foundry Finance Trust</p>
                                    <p><strong>Address:</strong> 84 Kingsward House, Newbury Lane, London, EC2V 4MN</p>
                                    <p><strong>Account Name:</strong> Medical Foundry Ltd</p>
                                    <p><strong>Account No:</strong> 20483715</p><p><strong>Sort Code:</strong> 52-41-73</p>
                                    <p><strong>IBAN:</strong> GB21 MDFT 5241 7320 4837 15</p>
                                    <p><strong>SWIFT/BIC:</strong> MDFTGB2L</p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.bank_transfer.cta.info_html',
                'label'         => 'Bank transfer payment method cta information html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<strong>Bank Transfer</strong><br><p>If you select bank transfer, your place will not be reserved until payment has been confirmed</p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.bank_transfer.cta.button_label',
                'label'         => 'Bank transfer booking payment method cta label',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'Pay by bank transfer',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.bank_transfer.information.header_html',
                'label'         => 'Bank transfer booking payment information header html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-lg font-semibold mb-1">Thank you for registering for this event</h3>
                                    <p class="text-sm text-[var(--color-text-light)]">
                                        Our team have been notified of your application.
                                    </p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.bank_transfer.information.details_intro_html',
                'label'         => 'Bank transfer booking payment information details intro html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<p class="font-semibold">
                                        Please arrange payment with your bank using the details below.
                                    </p>
                                    <p class="text-[var(--color-text-light)]">
                                        We have also sent you an email with full details for your convenience.
                                    </p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.bank_transfer.information.details_footer_html',
                'label'         => 'Bank transfer booking payment information footer html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<p class="text-sm">If you do not receive an email, please check your spam or junk folder.
                                    We recommend adding <strong>demo@eventscan.co.uk</strong> to your contacts to ensure future emails and updates are received.
                                    <br><br>
                                    Please note that your place will not be reserved until payment has been received and confirmed by our office.</p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.stripe.cta.info_html',
                'label'         => 'Stripe payment booking method cta information html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<img src="/images/frontend/stripe.png" alt="Stripe Secure Payments" class="mt-2 h-8 inline-block opacity-80"><br>
                                    <strong>Secure card payment</strong><br>
                                    <p>Payment will be processed securely via Stripe.</p>',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.booking.stripe.cta.button_label',
                'label'         => 'Stripe booking payment method cta label',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'Pay by card',
            ],
            [
                'category_id'   => 7,
                'key_name'      => 'payment.admin.stripe.payments_url',
                'label'         => 'Stripe payments url',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'https://dashboard.stripe.com/payments/',
            ]
        ]);
    }
}
