<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterEmailSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Email\EmailBroadcastTypeCategoriesSeeder::class,
            \Database\Seeders\Email\EmailBroadcastTypesSeeder::class,
            \Database\Seeders\Email\EmailHtmlContentSeeder::class,
            \Database\Seeders\Email\EmailHtmlLayoutsSeeder::class,
            \Database\Seeders\Email\EmailSignatureSeeder::class,
        ]);
    }
}
