<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingsCheckInAppSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.scheme',
                'label'         => 'Scheme',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'eventscancheckin',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.apple_download_url',
                'label'         => 'Apple download url',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'https://apps.apple.com/gb/app/eventscan-check-in/id6749772623',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.android_download_url',
                'type'          => 'text',
                'label'         => 'Android download url',
                'display_order' => 3,
                'value'         => 'https://play.google.com/store/apps/details?id=com.wearedarsh.eventscancheckin',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.qr_prefix',
                'type'          => 'text',
                'label'         => 'QR Prefix',
                'display_order' => 4,
                'value'         => 'd543',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.friendly_name',
                'type'          => 'text',
                'label'         => 'Friendly name',
                'display_order' => 5,
                'value'         => 'Check In app',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.support_email',
                'type'          => 'text',
                'label'         => 'Support email',
                'display_order' => 6,
                'value'         => 'support@eventscan.co.uk',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.privacy_email',
                'type'          => 'text',
                'label'         => 'Privacy email',
                'display_order' => 7,
                'value'         => 'privacy@eventscan.co.uk',
            ],
        ]);
    }
}
