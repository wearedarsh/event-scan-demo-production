<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingCheckInAppSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.scheme',
                'label'         => 'Scheme',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => 'eventscancheckin',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.apple_download_url',
                'label'         => 'Apple download url',
                'type'          => 'text',
                'display_order' => 2,
                'value'         => 'https://apps.apple.com/gb/app/eventscan-check-in/id6749772623',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.android_download_url',
                'type'          => 'text',
                'label'         => 'Android download url',
                'display_order' => 3,
                'value'         => 'https://play.google.com/store/apps/details?id=com.wearedarsh.eventscancheckin',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.qr_prefix',
                'type'          => 'text',
                'label'         => 'QR Prefix',
                'display_order' => 4,
                'value'         => 'd543',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.friendly_name',
                'type'          => 'text',
                'label'         => 'Friendly name',
                'display_order' => 5,
                'value'         => 'Check In app',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.support_email',
                'type'          => 'text',
                'label'         => 'Support email',
                'display_order' => 6,
                'value'         => 'support@eventscan.co.uk',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.privacy_email',
                'type'          => 'text',
                'label'         => 'Privacy email',
                'display_order' => 7,
                'value'         => 'privacy@eventscan.co.uk',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.support.header_html',
                'type'          => 'textarea',
                'label'         => 'Check in app support page header html',
                'display_order' => 8,
                'value'         => '<h1 class="text-4xl md:text-5xl font-bold mb-4">Check in app support</h1>
                                    <p class="text-lg text-white/90 mb-10">
                                    Technical assistance and information for authorised check in app users.
                                    </p>',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.support.content_html',
                'type'          => 'textarea',
                'label'         => 'Check in app support page content html',
                'display_order' => 9,
                'value'         => '<p>
                                    The <strong>Check in app</strong> is designed exclusively for authorised Medical Foundry account holders to manage
                                    secure badge scanning and attendance tracking during events.
                                    It is <strong>not intended for public use</strong> — access requires a valid Medical Foundry account and a provisioning link.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Contact Support</h2>
                                    <p>
                                    For any technical issues, setup questions, or assistance using the app, please contact our support team:
                                    <br>
                                        support@eventscan.co.uk
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Important Notes</h2>
                                    <ul class="list-disc list-inside space-y-1">
                                    <li>This app is <strong>not for public use</strong>.</li>
                                    <li>Access requires a valid Check in app account and provisioning link.</li>
                                    <li>Use is restricted to authorised event staff and organisers.</li>
                                    </ul>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">About the App</h2>
                                    <p>
                                    The <strong>Check in app</strong> is built for <strong>fast, secure, and reliable badge scanning</strong>,
                                    seamlessly integrated with the Medical Foundry platform.
                                    It offers:
                                    </p>
                                    <ul class="list-disc list-inside space-y-1">
                                    <li>Ultra-fast QR badge scanning with <strong>offline capability</strong></li>
                                    <li>Event and session selection for check-in management</li>
                                    <li>Secure login for authorised Check in app users</li>
                                    <li>Fully encrypted data transmission</li>
                                    </ul>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Review Mode (For App Reviewers Only)</h2>
                                    <ol class="list-decimal list-inside space-y-2">
                                    <li>On the initial provisioning screen, tap <strong>“Access Review Mode.”</strong><br>
                                        <em>This mode displays a clear banner across all screens indicating Review Mode.</em>
                                    </li>
                                    <li>The login screen is pre-filled with test credentials (fields are locked). Tap <strong>Login</strong> to continue.</li>
                                    <li>Choose any of the sample event or session items to reach the scan screen.</li>
                                    </ol>
                                    <p><em>Review Mode contains only dummy data and no personal information.</em></p>
                                    ',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.privacy.header_html',
                'type'          => 'textarea',
                'label'         => 'Check in app privacy page header html',
                'display_order' => 9,
                'value'         => '<h1 class="text-4xl md:text-5xl font-bold mb-4">Check in app privacy policy</h1>
                                    <p class="text-lg text-white/90 mb-10">
                                    Your privacy and data security are important to us.
                                    </p>',
            ],
            [
                'category_id'   => 5,
                'key_name'      => 'check_in_app.privacy.content_html',
                'type'          => 'textarea',
                'label'         => 'Check in app privacy page content html',
                'display_order' => 10,
                'value'         => '<h2 class="text-lg font-semibold text-[var(--color-secondary)]">Overview</h2>
                                    <p>
                                    The <strong>Check in app</strong> application and platform are provided by 
                                    <strong>Medical Foundry</strong> 
                                    to manage event registrations, attendee check-ins, and related communications.
                                    We are committed to <strong>protecting your personal information</strong> and handling it responsibly.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Information We Collect</h2>
                                    <ul class="list-disc list-inside space-y-1">
                                    <li>Attendee and registration details you provide during event signup</li>
                                    <li>Badge or QR code data used for event check-in and attendance tracking</li>
                                    <li>Basic login credentials (email and password)</li>
                                    <li>Device permissions (e.g. camera) when using our mobile or check-in applications</li>
                                    </ul>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">How We Use Your Information</h2>
                                    <p>
                                    Your information is used solely to <strong>facilitate your event participation</strong> — including registration, attendance management, ticketing, and essential event communications.
                                    We do <strong>not sell, rent, or share</strong> your personal information with third parties, except where required to deliver event services securely.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Data Storage & Security</h2>
                                    <p>
                                    All personal data is stored securely in accordance with <strong>UK GDPR</strong> and relevant data protection legislation.
                                    We apply <strong>encryption</strong> and <strong>restricted access controls</strong> to safeguard your information.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Device Permissions</h2>
                                    <p>
                                    When using our check-in tools, the app may request access to your device’s camera to scan attendee QR codes.
                                    These permissions are used <strong>only for that purpose</strong> and are <strong>not stored or transmitted</strong> elsewhere.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Your Rights</h2>
                                    <p>
                                    You have the right to <strong>access, correct, or request deletion</strong> of your data at any time.
                                    If you wish to make such a request, please contact us using the details below.
                                    </p>

                                    <hr class="border-[var(--color-border)]">

                                    <h2 class="text-lg font-semibold text-[var(--color-secondary)]">Contact</h2>
                                    <p>
                                    For questions about this policy or to exercise your data rights, please contact our data team at:
                                    <br>
                                    <strong>privacy@eventscan.co.uk</strong>
                                    </p>',
            ],
        ]);
    }
}
