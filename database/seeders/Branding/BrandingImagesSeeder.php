<?php

namespace Database\Seeders\Branding;

use Illuminate\Database\Seeder;
use App\Models\BrandingImage;
use App\Models\BrandingPlatform;

class BrandingImagesSeeder extends Seeder
{
    public function run(): void
    {
        $frontend = BrandingPlatform::where('key_name', 'frontend')->first();
        $backend  = BrandingPlatform::where('key_name', 'backend')->first();

        $images = [
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_logo',
                'path' => '/storage/branding/logo-frontend.png',
                'alt_text' => 'Frontend logo',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_logo_white',
                'path' => '/storage/branding/logo-white-frontend.png',
                'alt_text' => 'Frontend logo (white)',
            ],

            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_favicon',
                'path' => '/storage/branding/favicon-frontend.svg',
                'alt_text' => 'Frontend favicon',
            ],
            [
                'branding_platform_id' => $backend->id,
                'key_name' => 'backend_favicon',
                'path' => '/storage/branding/favicon-frontend-backend.svg',
                'alt_text' => 'Backend favicon',
            ],

            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_header_background',
                'path' => '/storage/branding/header-bg-frontend.jpg',
                'alt_text' => 'Frontend header background',
            ],
        ];

        foreach ($images as $image) {
            BrandingImage::updateOrCreate(
                [
                    'branding_platform_id' => $image['branding_platform_id'],
                    'key_name' => $image['key_name'],
                ],
                [
                    'path' => $image['path'],
                    'alt_text' => $image['alt_text'],
                ]
            );
        }
    }
}
