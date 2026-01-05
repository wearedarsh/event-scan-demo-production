<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsGeneralSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 6,
                'key_name'      => 'currency_symbol',
                'label'         => 'Currency symbol',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => '£',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'customer_friendly_name',
                'label'         => 'Customer friendly name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'event_friendly_name',
                'label'         => 'Event friendly name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Event',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'attendee_friendly_name',
                'label'         => 'Attendee friendly name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Attendee',
            ],

        ]);
    }
}
