<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailSignature;
use Illuminate\Support\Facades\DB;

class EmailSignatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $email_signatures = [
            ['key_name' => 'john_doe', 
                'title' => 'John Doe', 
                'html_content' => '<p><strong>Many thanks<br>Eventscan</p>',
                'active' => true
            ]
        ];
        EmailSignature::insert($email_signatures);
    }
}
