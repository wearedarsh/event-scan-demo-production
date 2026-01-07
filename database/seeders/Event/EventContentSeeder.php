<?php

namespace Database\Seeders\Event;

use Illuminate\Database\Seeder;
use App\Models\EventContent;

class EventContentSeeder extends Seeder
{
    public function run(): void
    {
        $event_contents = [
            [
                'id' => 1,
                'event_id' => 1,
                'title' => 'Event Overview',
                'html_content' => '
                    <h3>Welcome</h3>
                    <p>Welcome to the <strong>Medical Imaging & Diagnostics Forum 2025</strong>, hosted by Medical Foundry. This two-day learning and development event brings together clinicians, researchers, and medical technology professionals from across the UK.</p>

                    <p>Across keynote sessions, hands-on demonstrations, and specialist workshops, delegates will explore the latest advances in diagnostic imaging, clinical workflows, and applied healthcare technology.</p>

                    <h3>What to Expect</h3>
                    <ul>
                        <li>Keynotes from leading consultants and clinical technologists</li>
                        <li>Live demonstrations of imaging and diagnostic tools</li>
                        <li>Interactive workshops and small-group teaching</li>
                        <li>Networking with peers and industry partners</li>
                    </ul>

                    <h3>Who Should Attend</h3>
                    <p>This event is ideal for radiographers, clinicians, medical technicians, researchers, and early-career professionals seeking deeper knowledge in diagnostic practice.</p>
                ',
                'display_order' => 1,
                'active' => 1,
            ],

            [
                'id' => 2,
                'event_id' => 1,
                'title' => 'Venue & Travel Information',
                'html_content' => '
                    <h3>Venue</h3>
                    <p><strong>The Exchange Conference Centre</strong><br>123 City Road,<br>London EC1V 1AA,<br>United Kingdom</p>
                    <p>The venue offers state-of-the-art lecture spaces and breakout rooms designed for hands-on sessions.</p>

                    <h3>Travel</h3>
                    <p><strong>Nearest Underground:</strong> Old Street (5 minutes walk)<br>
                    <strong>National Rail:</strong> Liverpool Street Station (10 minutes by taxi)</p>

                    <h3>Parking</h3>
                    <p>Limited on-site parking is available. Delegates are encouraged to use public transport where possible.</p>
                ',
                'display_order' => 2,
                'active' => 1,
            ],

            [
                'id' => 3,
                'event_id' => 1,
                'title' => 'Accommodation & Contact',
                'html_content' => '
                    <h3>Recommended Hotels</h3>
                    <p>Delegates can benefit from preferred rates at the following partner hotels:</p>
                    <ul>
                        <li><strong>CityPoint Hotel</strong> – 5 minutes walk</li>
                        <li><strong>Urban Stay London</strong> – 10 minutes walk</li>
                    </ul>

                    <h3>Support</h3>
                    <p>If you need help with travel or arrangements, the Medical Foundry events team will be happy to assist.</p>

                    <h3>Contact</h3>
                    <p><strong>Medical Foundry Events Team</strong><br>
                    Email: <a href="mailto:events@medicalfoundry.co.uk">events@medicalfoundry.co.uk</a></p>
                ',
                'display_order' => 3,
                'active' => 1,
            ],
            [
                'id' => 4,
                'event_id' => 2,
                'title' => 'Event Overview',
                'html_content' => '
                    <h3>Provisional Event</h3>
                    <p>This upcoming Medical Foundry event is currently in planning. Full programme details, schedule, and ticket availability will be released soon.</p>

                    <p>To register interest, please check back shortly or contact the events team for early updates.</p>
                ',
                'display_order' => 1,
                'active' => 1,
            ],

            [
                'id' => 5,
                'event_id' => 3,
                'title' => 'Event Overview',
                'html_content' => '
                    <h3>About This Event</h3>
                    <p>The <strong>Advanced Skills Workshop: Emergency Airway Management</strong> is now fully booked. This immersive one-day course provides supervised, practical training for clinicians working in emergency and critical care settings.</p>

                    <h3>Course Focus</h3>
                    <ul>
                        <li>Airway assessment & clinical decision-making</li>
                        <li>Hands-on equipment training</li>
                        <li>Simulated emergency scenarios</li>
                        <li>Team communication & rapid response practice</li>
                    </ul>

                    <p>If you would like to be added to the waiting list, please contact the Medical Foundry events team.</p>
                ',
                'display_order' => 1,
                'active' => 1,
            ],

        ];

        EventContent::insert($event_contents);
    }
}
