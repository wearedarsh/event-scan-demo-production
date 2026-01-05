<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsBookingSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.middle_column_html',
                'label'         => 'Footer middle column html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Questions?</h3>
                                    <p class="mb-2">Feel free to get in touch with any queries.</p>
                                    <p>
                                        <a href="mailto:" class="text-[var(--color-primary)] hover:underline font-medium">
                                        support@eventscan.co.uk
                                        </a>
                                    </p>
                                    <p class="mt-1 opacity-80">+44 01234 567 890</p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.right_column_html',
                'label'         => 'Footer right column html',
                'display_order' => 2,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Company</h3>
                                    <p>Medical Foundry</p>
                                    <p>13 Mary lane</p>
                                    <p>London, M3D 4OU</p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.left_column_html',
                'label'         => 'Footer left column html',
                'display_order' => 2,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Secure Payments</h3>
                                    <img src="images/frontend/stripe.png" alt="Stripe Secure Payments" class="h-8 inline-block opacity-80">
                                    <p class="mt-3 leading-relaxed">
                                        We accept all major cards via Stripe - your transactions are encrypted and protected.
                                    </p>',
            ],
        ]);
    }
}
