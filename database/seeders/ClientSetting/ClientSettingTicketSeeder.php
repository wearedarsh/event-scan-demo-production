<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingTicketSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 9,
                'key_name'      => 'ticket.document_upload.file_rules',
                'label'         => 'Ticket document upload file rules',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '["file","max:10240","mimes:jpg,png,pdf,doc,docx"]',
            ],            
        ]);
    }
}
