<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 1, // Email
                'key_name'      => 'from_address',
                'label'         => 'From email address',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'demo@eventscan.co.uk',
            ],
            [
                'category_id'   => 1, // Email
                'key_name'      => 'from_name',
                'label'         => 'From name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 1, // Email
                'key_name'      => 'transactional_signature_html',
                'type'          => 'textarea',
                'label'         => 'Transactional email signature',
                'display_order' => 3,
                'value'         => '<p>Kind regards,<br>The Medical Foundry Team</p>',
            ],
        ]);
    }
}
