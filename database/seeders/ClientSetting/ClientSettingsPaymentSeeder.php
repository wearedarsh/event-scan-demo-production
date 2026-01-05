<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsPaymentSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 7,
                'key_name'      => 'payment.bank_transfer_detail_html',
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
                'key_name'      => 'payment.stripe_payments',
                'label'         => 'Stripe payments url',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'https://dashboard.stripe.com/payments/',
            ]
        ]);
    }
}
