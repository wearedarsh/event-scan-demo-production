<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventPaymentMethod;

class EventPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event_payment_methods = [
            [
                'id' => 1, 
                'event_id' => 1,
                'name' => 'Stripe card payment',
                'payment_method' => 'stripe',
                'enabled' => true,
                'description' =>  'If you select credit/debit card you will be taken to <strong>Stripe</strong> where payment will be taken securely.<br><br>',
            ],
            [
                'id' => 2, 
                'event_id' => 1,
                'name' => 'Bank transfer',
                'payment_method' => 'bank_transfer',
                'enabled' => false,
                'description' =>  'If you select bank transfer please note that your place will not be reserved until payment has been received and confirmed by our office.',
            ]
        ];

        EventPaymentMethod::insert($event_payment_methods);
    }
}
