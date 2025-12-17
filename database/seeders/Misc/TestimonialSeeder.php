<?php

namespace Database\Seeders\Misc;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'id' => 1,
                'content' => 'Medical Foundry consistently delivers exceptionally well-organised educational events. The sessions were insightful, the faculty were outstanding, and the entire experience felt highly professional from start to finish.',
                'title' => 'Dr. Hannah Patel',
                'sub_title' => 'Consultant Vascular Surgeon',
                'star_rating' => 5,
                'active' => 1,
            ],
            [
                'id' => 2,
                'content' => 'The conference exceeded expectations. Registration was smooth, communication was clear throughout, and the workshops provided practical skills I was able to use immediately in clinic.',
                'title' => 'Michael Sheridan',
                'sub_title' => 'Senior Clinical Fellow',
                'star_rating' => 5,
                'active' => 1,
            ],
            [
                'id' => 3,
                'content' => 'A superb programme with a strong academic focus. The speakers were engaging and the agenda was well-structured, making it easy to get genuine value from each session.',
                'title' => 'Dr. Laura Kim',
                'sub_title' => 'GP & Medical Educator',
                'star_rating' => 4,
                'active' => 1,
            ],
            [
                'id' => 4,
                'content' => 'I’ve attended several Medical Foundry events and each one has been excellent. The team clearly puts a huge amount of care into planning — everything runs smoothly and delegates are looked after brilliantly.',
                'title' => 'Professor Mark O’Neill',
                'sub_title' => 'Head of Clinical Research',
                'star_rating' => 5,
                'active' => 1,
            ]
        ];

        Testimonial::insert($testimonials);
    }
}
