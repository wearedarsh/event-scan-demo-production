<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventHtmlEmailContent;

class EventHtmlEmailContentSeeder extends Seeder
{
    public function run(): void
    {
        EventHtmlEmailContent::insert([
            [
                'event_id' => 1,
                'key_name' => 'customer_welcome_email',
                'label' => 'Customer Welcome Email',
                'subject' => 'Welcome to your upcoming event!',
                'pre_header' => 'Everything you need to know before the event starts.',
                'html_content' => file_get_contents(resource_path('views/emails/customer/welcome.blade.php')),
            ],
        ]);
    }
}
