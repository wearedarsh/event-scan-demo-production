<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterBrandingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Branding\BrandingCssSeeder::class,
            \Database\Seeders\Branding\BrandingImagesSeeder::class,
            \Database\Seeders\Branding\BrandingPlatformsSeeder::class,
            \Database\Seeders\Email\EmailHtmlLayoutsSeeder::class,
            \Database\Seeders\Email\EmailSignatureSeeder::class,
        ]);
    }
}
