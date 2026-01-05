<?php

namespace Database\Seeders\Email;

use Illuminate\Database\Seeder;
use App\Models\EmailBroadcastType;

class EmailBroadcastTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'key_name' => 'transactional_customer',
                'label' => 'Customer',
                'category_id' => 1
            ],
            [
                'key_name' => 'transactional_admin',
                'label' => 'Admin',
                'category_id' => 1
            ],
            [
                'key_name' => 'admin_triggered',
                'label' => 'Single',
                'category_id' => 2
            ],
            [
                'key_name' => 'admin_triggered_bulk',
                'label' => 'Bulk',
                'category_id' => 2
            ],
        ];

        foreach ($types as $type) {
            EmailBroadcastType::updateOrCreate(
                ['key_name' => $type['key_name']],
                ['label' => $type['label'],
                'category_id' => $type['category_id']]
            );
        }
    }
}
