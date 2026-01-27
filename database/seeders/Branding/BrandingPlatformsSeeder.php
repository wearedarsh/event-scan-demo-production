<?php

namespace Database\Seeders\Branding;

use Illuminate\Database\Seeder;
use App\Models\BrandingPlatform;

class BrandingPlatformsSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            [
                'key_name' => 'frontend',
                'label' => 'Frontend',
            ],
            [
                'key_name' => 'backend',
                'label' => 'Backend',
            ],
            [
                'key_name' => 'pdf',
                'label' => 'PDF',
            ],
            [
                'key_name' => 'badges',
                'label' => 'Badges',
            ],
        ];

        foreach ($platforms as $platform) {
            BrandingPlatform::updateOrCreate(
                ['key_name' => $platform['key_name']],
                ['label' => $platform['label']]
            );
        }
    }
}
