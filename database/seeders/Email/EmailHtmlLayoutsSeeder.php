<?php

namespace Database\Seeders\Email;

use Illuminate\Database\Seeder;
use App\Models\EmailHtmlLayout;

class EmailHtmlLayoutsSeeder extends Seeder
{
    public function run(): void
    {
        $default_layout = file_get_contents(resource_path('views/emails/layouts/main.blade.php'));

        EmailHtmlLayout::insert([
            [
                'label' => 'Admin Email Layout',
                'key_name' => 'admin',
                'html_content' => $default_layout,
            ],
            [
                'label' => 'Customer Email Layout',
                'key_name' => 'customer',
                'html_content' => $default_layout,
            ],
        ]);
    }
}
