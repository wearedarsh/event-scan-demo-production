<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingLegalSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert(
            [
                [
                    'category_id'   => 8,
                    'key_name'      => 'legal.privacy.header_html',
                    'label'         => 'Privacy policy header html',
                    'display_order' => 1,
                    'type'          => 'textarea',
                    'value'         => '<h1 class="text-4xl md:text-5xl font-bold mb-4">Privacy Policy</h1>
                                        <p class="text-lg text-white/90 mb-10">
                                            Your privacy and data security are important to us.
                                        </p>',
                ],
                [
                    'category_id'   => 8,
                    'key_name'      => 'legal.cookies.header_html',
                    'label'         => 'Cookie policy header html',
                    'display_order' => 2,
                    'type'          => 'textarea',
                    'value'         => '<h1 class="text-4xl md:text-5xl font-bold mb-4">Cookies Policy</h1>
                                        <p class="text-lg text-white/90 mb-10">
                                        We take cookies and your privacy seriously.
                                        </p>',
                ],
                [
                    'category_id'   => 8,
                    'key_name'      => 'legal.privacy.content_html',
                    'label'         => 'Privacy policy content html',
                    'display_order' => 3,
                    'type'          => 'textarea',
                    'value'         => '<p class="text-[var(--color-text-light)]">Last updated: <strong>November 2025</strong></p>
                                        <p>
                                        <strong>Medical foundry</strong> (“we”, “our”, or “us”) respects your privacy and is committed to protecting your personal data. 
                                        This policy outlines how we collect, use, and protect information when you use our website and related services.
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">1. Information We Collect</h2>
                                        <ul class="list-disc list-inside space-y-2">
                                        <li><strong>Contact details</strong> — such as name, email, or phone number, when you contact us or book a demo.</li>
                                        <li><strong>Usage data</strong> — including pages visited, actions taken, and general website interaction data collected via analytics tools.</li>
                                        <li><strong>Cookies</strong> — small text files used to enhance your experience (see our <a href="/cookies-policy" class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">Cookies Policy</a>).</li>
                                        </ul>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">2. How We Use Your Information</h2>
                                        <ul class="list-disc list-inside space-y-2">
                                        <li>To respond to your enquiries or demo requests.</li>
                                        <li>To operate, maintain, and improve our website and services.</li>
                                        <li>To send relevant updates or information — only with your consent.</li>
                                        </ul>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">3. Data Security</h2>
                                        <p>
                                        We use <strong>secure systems</strong> and follow <strong>best practices</strong> to protect your personal information.
                                        However, please note that no online transmission is completely secure, and you share data at your own risk.
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">4. Your Rights</h2>
                                        <p>
                                        Under the <strong>UK GDPR</strong>, you have the right to access, correct, or request deletion of your personal data.
                                        To exercise these rights, contact us at:
                                        </p>
                                        <p><strong>Email:</strong> support@eventscan.co.uk</p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">5. Contact</h2>
                                        <p>
                                        For any questions regarding this policy, please contact:
                                        </p>
                                        <p>
                                        <strong>Medical Foundry</strong><br>
                                        Registered in England & Wales<br>
                                        Email: <strong>support@eventscan.co.uksort</strong>
                                        </p>'
                ],
                [
                    'category_id'   => 8,
                    'key_name'      => 'legal.cookies.content_html',
                    'label'         => 'Cookie policy content html',
                    'display_order' => 4,
                    'type'          => 'textarea',
                    'value'         => '<p class="text-[var(--color-text-light)]">Last updated: <strong>November 2025</strong></p>
                                        <p>
                                        This Cookies Policy explains how <strong>Check in app</strong> 
                                        (“we”, “our”, or “us”) uses cookies and similar technologies on our website 
                                        (<a href="https://eventscan.co.uk" class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">eventscan.co.uk</a>).
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">1. What Are Cookies?</h2>
                                        <p>
                                        Cookies are small text files stored on your device by your browser when you visit a website.
                                        They help us provide a <strong>better and more secure experience</strong> by remembering preferences,
                                        improving performance, and collecting analytics data.
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">2. Types of Cookies We Use</h2>
                                        <ul class="list-disc list-inside space-y-2">
                                        <li><strong>Essential Cookies</strong> — required for the site to function properly (e.g. session management, security).</li>
                                        <li><strong>Analytics Cookies</strong> — help us understand how visitors use our site so we can improve it (e.g. Google Analytics).</li>
                                        <li><strong>Preference Cookies</strong> — remember your settings or preferences, such as cookie consent.</li>
                                        </ul>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">3. Managing Cookies</h2>
                                        <p>
                                        You can accept or reject non-essential cookies via our on-site cookie banner.
                                        Most browsers also let you control cookies through their settings.
                                        You can block or delete cookies if you wish, but this may affect some parts of our website.
                                        </p>
                                        <p>
                                        To learn more about managing cookies, visit:
                                        <a href="https://www.allaboutcookies.org/" target="_blank" 
                                            class="text-[var(--color-accent)] hover:text-[var(--color-text-muted)] transition">
                                            www.allaboutcookies.org
                                        </a>.
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">4. Updates to This Policy</h2>
                                        <p>
                                        We may update this policy periodically. Any changes will be posted on this page
                                        with a new <strong>“last updated”</strong> date shown above.
                                        </p>

                                        <hr class="border-[var(--color-border)]">

                                        <h2 class="text-lg font-semibold text-[var(--color-secondary)]">5. Contact</h2>
                                        <p>
                                        For questions about this policy or how we use cookies, please contact:
                                        </p>
                                        <p>
                                        <strong>Check in app</strong>
                                        Email: <strong>support@eventscan.co.uk</strong>
                                        </p>',
                ]
            ]
        );
    }
}
