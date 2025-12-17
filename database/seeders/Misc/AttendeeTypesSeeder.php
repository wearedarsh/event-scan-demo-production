<?php

namespace Database\Seeders\Misc;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AttendeeType;

class AttendeeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('attendee_types')->truncate();

        $attendee_types = [
            ['name' => 'Academic / Researcher',         'active' => true, 'key_name' => 'academic_researcher'],
            ['name' => 'Industry Professional',         'active' => true, 'key_name' => 'industry_professional'],
            ['name' => 'Healthcare Professional',       'active' => true, 'key_name' => 'healthcare_professional'],
            ['name' => 'Student / Trainee',             'active' => true, 'key_name' => 'student_trainee'],
            ['name' => 'Educator / Lecturer',           'active' => true, 'key_name' => 'educator_lecturer'],
            ['name' => 'Consultant / Advisor',          'active' => true, 'key_name' => 'consultant_advisor'],
            ['name' => 'Business / Management',         'active' => true, 'key_name' => 'business_management'],
            ['name' => 'Technical / Engineering',       'active' => true, 'key_name' => 'technical_engineering'],
            ['name' => 'Media / Communications',        'active' => true, 'key_name' => 'media_communications'],
            ['name' => 'Other',                         'active' => true, 'key_name' => 'other'],
        ];

        AttendeeType::insert($attendee_types);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
