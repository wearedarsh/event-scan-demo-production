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
                'key_name' => 'backend_admin',
                'label' => 'Backend admin',
            ],
            [
                'key_name' => 'backend_customer',
                'label' => 'Backend customer',
            ],
            [
                'key_name' => 'registration',
                'label' => 'Registration',
            ],
            [
                'key_name' => 'pdf',
                'label' => 'PDF',
            ],
            [
                'key_name' => 'badges',
                'label' => 'Badges',
            ],
            [   
                'key_name' => 'email',
                'label' => 'Email'
            ]
        ];

        foreach ($platforms as $platform) {
            BrandingPlatform::updateOrCreate(
                ['key_name' => $platform['key_name']],
                ['label' => $platform['label']]
            );
        }
    }
}
