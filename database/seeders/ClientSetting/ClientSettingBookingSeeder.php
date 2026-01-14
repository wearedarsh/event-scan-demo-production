<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingBookingSeeder extends Seeder
{
    public function run(): void
    {
        ClientSetting::insert([
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.middle_column_html',
                'label'         => 'Footer middle column html',
                'display_order' => 1,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Questions?</h3>
                                    <p class="mb-2">Feel free to get in touch with any queries.</p>
                                    <p>
                                        <a href="mailto:support@eventscan.co.uk" class="text-[var(--color-primary)] hover:underline font-medium">
                                        support@eventscan.co.uk
                                        </a>
                                    </p>
                                    <p class="mt-1 opacity-80">+44 01234 567 890</p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.right_column_html',
                'label'         => 'Footer right column html',
                'display_order' => 2,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Company</h3>
                                    <p>Medical Foundry</p>
                                    <p>13 Mary lane</p>
                                    <p>London, M3D 4OU</p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.footer.left_column_html',
                'label'         => 'Footer left column html',
                'display_order' => 3,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-[var(--color-text)] font-semibold mb-3">Secure Payments</h3>
                                    <img src="/images/frontend/stripe.png" alt="Stripe Secure Payments" class="h-8 inline-block opacity-80">
                                    <p class="mt-3 leading-relaxed">
                                        We accept all major cards via Stripe - your transactions are encrypted and protected.
                                    </p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.testimonial.header_html',
                'label'         => 'Testimonial header html',
                'display_order' => 4,
                'type'          => 'textarea',
                'value'         => '<h2 class="text-3xl md:text-4xl font-bold text-[var(--color-text)]">Testimonials</h2>
                                    <p class="mt-4 text-[var(--color-text-light)] max-w-2xl mx-auto">
                                    Hear from our attendees about their experiences at our workshops and conferences.
                                    </p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.hero.header_html',
                'label'         => 'Homepage hero header html',
                'display_order' => 5,
                'type'          => 'textarea',
                'value'         => '<h1 class="text-4xl md:text-5xl font-bold mb-4">Medical Foundry events</h1>
                                    <p class="text-lg text-[var(--color-surface)]/90 mb-10">
                                        Register for our upcoming global events
                                    </p>
                                    <a href="#our-events"
                                        class="inline-flex items-center justify-center px-6 py-2 rounded-xl font-semibold border border-[var(--color-surface)] text-[var(--color-surface)] hover:bg-[var(--color-surface)] hover:text-[var(--color-primary)] transition">
                                        Explore events
                                    </a>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.events.header_html',
                'label'         => 'Homepage event header html',
                'display_order' => 6,
                'type'          => 'textarea',
                'value'         => '<h2 class="text-3xl font-semibold text-[var(--color-text)]">Our Events</h2>
                                    <p class="mt-3 text-[var(--color-text-light)] max-w-2xl mx-auto">
                                    Explore our upcoming events and register now.
                                    </p>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.nav.dropdown_title',
                'label'         => 'Event dropdown title',
                'display_order' => 7,
                'type'          => 'text',
                'value'         => 'Our events',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.event_nav.dropdown_title',
                'label'         => 'Event sub nav dropdown title',
                'display_order' => 8,
                'type'          => 'text',
                'value'         => 'Event information',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.approval_complete.header_html',
                'label'         => 'Booking approval complete header html',
                'display_order' => 9,
                'type'          => 'textarea',
                'value'         => '<h3 class="text-lg font-semibold text-[var(--color-secondary)]">Thank you for your registration</h3>',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.approval_complete.content_html',
                'label'         => 'Booking approval complete content html',
                'display_order' => 10,
                'type'          => 'textarea',
                'value'         => '<p>Thank you for your registration, a member of our team has received your registraion and will be in touch shortly',
            ],
            [
                'category_id'   => 3,
                'key_name'      => 'booking.navigation.final_step_label',
                'label'         => 'Booking navigation final step label',
                'display_order' => 11,
                'type'          => 'text',
                'value'         => '<p>Thank you for your registration, a member of our team has received your registraion and will be in touch shortly',
            ]
            
        ]);
    }
}
