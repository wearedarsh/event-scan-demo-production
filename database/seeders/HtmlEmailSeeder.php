<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailHtmlContent;
use Illuminate\Support\Facades\DB;

class HtmlEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $html_contents = [
            [
                'id' => 1,
                'title' => 'Customer welcome email',
                'key_name' => 'customer_welcome_email',
                'html_content' => '
                    <p>
                        Thank you for registering for your upcoming event. We’re delighted to have you onboard and look forward to welcoming you.
                    </p>

                    <p>
                        This email confirms your registration and provides a few useful details to help you prepare. Further information will be sent to you as the event approaches.
                    </p>

                    <p>
                        <strong>What happens next?</strong><br>
                        You will receive updates, reminders and any important instructions directly by email. If your event includes digital tickets, your access details will also be sent to you before the event begins.
                    </p>

                    <p>
                        <strong>Need help?</strong><br>
                        If you have any questions regarding your registration, payment, special requirements or attending the event, simply reply to this email and a member of our team will be happy to assist.
                    </p>

                    <p>
                        We look forward to seeing you soon.<br><br>
                        <strong>The Medical Foundry Team</strong>
                    </p>
                ',
            ],
        ];

        EmailHtmlContent::insert($html_contents);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
