<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingGeneralSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 6,
                'key_name'      => 'general.currency_symbol',
                'label'         => 'Currency symbol',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => '£',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.customer_friendly_name',
                'label'         => 'Customer friendly name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.event_friendly_name',
                'label'         => 'Event friendly name',
                'type'          => 'text',
                'display_order' => 3,
                'value'         => 'Event',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.attendee_friendly_name',
                'label'         => 'Attendee friendly name',
                'type'          => 'text',
                'display_order' => 4,
                'value'         => 'Attendee',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.booking_reference_prefix',
                'label'         => 'Booking reference prefix',
                'type'          => 'text',
                'display_order' => 5,
                'value'         => 'ES',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.support_email',
                'label'         => 'Support email',
                'type'          => 'text',
                'display_order' => 6,
                'value'         => 'support@eventscan.co.uk',
            ],
            [
                'category_id'   => 6,
                'key_name'      => 'general.privacy_email',
                'label'         => 'Privacy email',
                'type'          => 'text',
                'display_order' => 7,
                'value'         => 'privacy@eventscan.co.uk',
            ],

        ]);
    }
}
