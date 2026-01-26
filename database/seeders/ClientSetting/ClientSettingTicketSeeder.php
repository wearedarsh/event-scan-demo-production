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
                'type'          => 'text',
                'value'         => '["file","max:10240","mimes:jpg,png,pdf,doc,docx"]',
            ],   
            [
                'category_id'   => 9,
                'key_name'      => 'ticket.document_upload.messages.max',
                'label'         => 'Ticket document upload messages max',
                'display_order' => 2,
                'type'          => 'text',
                'value'         => 'Please upload a file smaller than 10mb',
            ], 
            [
                'category_id'   => 9,
                'key_name'      => 'ticket.document_upload.messages.required',
                'label'         => 'Ticket document upload messages required',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => '["file","max:10240","mimes:jpg,png,pdf,doc,docx"]',
            ], 
            [
                'category_id'   => 9,
                'key_name'      => 'ticket.document_upload.messages.mimes',
                'label'         => 'Ticket document upload messages mimes',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'Please upload a file that is jpg,png,pdf,doc or docx',
            ], 
            [
                'category_id'   => 9,
                'key_name'      => 'ticket.document_upload.messages.file',
                'label'         => 'Ticket document upload messages file',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'The uploaded file is not valid',
            ],          
        ]);
    }
}
