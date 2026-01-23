<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingEmailSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 1,
                'key_name'      => 'email.customer.from_address',
                'label'         => 'Customer from email address',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'demo@eventscan.co.uk',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.customer.from_name',
                'label'         => 'Customer from name',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.admin.from_address',
                'label'         => 'Admin from email address',
                'display_order' => 3,
                'type'          => 'text',
                'value'         => 'demo@eventscan.co.uk',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.admin.from_name',
                'label'         => 'Admin from name',
                'type'          => 'text',
                'display_order' => 4,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.transactional.from_address',
                'label'         => 'Transactional from email address (eg forgotten password)',
                'display_order' => 5,
                'type'          => 'text',
                'value'         => 'demo@eventscan.co.uk',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.transactional.from_name',
                'label'         => 'Transactional from name (eg forgotten password)',
                'type'          => 'text',
                'display_order' => 6,
                'value'         => 'Medical Foundry',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.customer.signature_html',
                'type'          => 'textarea',
                'label'         => 'Customer signature html',
                'display_order' => 7,
                'value'         => '<p>Kind regards,<br>The Medical Foundry Team</p>',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.config.send_second_email_with_receipt',
                'type'          => 'select',
                'label'         => 'Send second email with receipt eg. welcome email',
                'display_order' => 7,
                'value'         => true,
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.marketing.service.name',
                'type'          => 'text',
                'label'         => 'Email opt in marketing service eg emailblaster or mailchimp',
                'display_order' => 7,
                'value'         => 'emailblaster',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'email.marketing.service.general_list_id',
                'type'          => 'text',
                'label'         => 'Email marketing general marketing list id',
                'display_order' => 7,
                'value'         => '',
            ],

        ]);
    }
}
