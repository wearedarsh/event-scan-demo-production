<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsEmailSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 1,
                'key_name'      => 'email.from_address',
                'label'         => 'From email address',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'demo@eventscan.co.uk',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.from_name',
                'label'         => 'From name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.transactional_signature_html',
                'type'          => 'textarea',
                'label'         => 'Transactional signature',
                'display_order' => 3,
                'value'         => '<p>Kind regards,<br>The Medical Foundry Team</p>',
            ],
        ]);
    }
}
