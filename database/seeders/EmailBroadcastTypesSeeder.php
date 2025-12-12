<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailBroadcastType;

class EmailBroadcastTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'key_name' => 'transactional_customer',
                'label' => 'Transactional customer',
            ],
            [
                'key_name' => 'transactional_admin',
                'label' => 'Transactional admin',
            ],
            [
                'key_name' => 'admin_triggered',
                'label' => 'Admin triggered',
            ],
            [
                'key_name' => 'admin_bulk_send',
                'label' => 'Admin bulk send',
            ],
        ];

        foreach ($types as $type) {
            EmailBroadcastType::updateOrCreate(
                ['key_name' => $type['key_name']],
                ['label' => $type['label']]
            );
        }
    }
}
