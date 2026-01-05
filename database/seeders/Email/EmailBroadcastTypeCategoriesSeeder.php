<?php

namespace Database\Seeders\Email;

use Illuminate\Database\Seeder;
use App\Models\EmailBroadcastTypeCategory;

class EmailBroadcastTypeCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'key_name' => 'transactional',
                'label' => 'System',
            ],
            [
                'id' => 2,
                'key_name' => 'sent_by_team',
                'label' => 'Sent by team',
            ]
        ];

        foreach ($categories as $category) {
            EmailBroadcastTypeCategory::updateOrCreate(
                ['key_name' => $category['key_name']],
                ['label' => $category['label']]
            );
        }
    }
}
