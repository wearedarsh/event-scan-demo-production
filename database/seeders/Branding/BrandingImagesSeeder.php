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
                'alt_text' => 'Frontend main logo',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_favicon',
                'path' => '/storage/branding/favicon-frontend.svg',
                'alt_text' => 'Frontend favicon',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_registration_logo',
                'path' => '/storage/branding/logo-registration-frontend.png',
                'alt_text' => 'Frontend registration logo',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_registration_favicon',
                'path' => '/storage/branding/favicon-registration.svg',
                'alt_text' => 'Frontend registration favicon',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_header_background',
                'path' => '/storage/branding/header-bg-frontend.jpg',
                'alt_text' => 'Frontend header background',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_login_background',
                'path' => '/storage/branding/login-full-bg-frontend.jpg',
                'alt_text' => 'Frontend login background',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_auth_logo',
                'path' => '/storage/branding/logo-auth-frontend.png',
                'alt_text' => 'Frontend auth/login logo',
            ],
            [
                'branding_platform_id' => $frontend->id,
                'key_name' => 'frontend_auth_favicon',
                'path' => '/storage/branding/favicon-auth-frontend.svg',
                'alt_text' => 'Frontend auth/login favicon',
            ],





            [
                'branding_platform_id' => $backend->id,
                'key_name' => 'backend_admin_logo',
                'path' => '/storage/branding/logo-admin-backend.png',
                'alt_text' => 'Backend admin logo',
            ],
            [
                'branding_platform_id' => $backend->id,
                'key_name' => 'backend_customer_logo',
                'path' => '/storage/branding/logo-customer-backend.png',
                'alt_text' => 'Backend customer logo',
            ],
            [
                'branding_platform_id' => $backend->id,
                'key_name' => 'backend_admin_favicon',
                'path' => '/storage/branding/favicon-admin-backend.svg',
                'alt_text' => 'Backend admin favicon',
            ],
            [
                'branding_platform_id' => $backend->id,
                'key_name' => 'backend_customer_favicon',
                'path' => '/storage/branding/favicon-customer-backend.svg',
                'alt_text' => 'Backend customer favicon',
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
