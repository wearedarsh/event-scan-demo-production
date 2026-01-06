<?php

namespace Database\Seeders\RegistrationForm;

use Illuminate\Database\Seeder;
use App\Models\RegistrationForm;

class RegistrationFormsSeeder extends Seeder
{
    public function run(): void
    {
        RegistrationForm::updateOrCreate(
            ['key_name' => 'default_paying_registration_form'],
            [
                'label'       => 'Default paying registration form',
                'description' => 'The standard registration form for all paying events for this company',
                'type'        => 'paid',
                'is_active'   => true,
            ]
        );

        RegistrationForm::updateOrCreate(
            ['key_name' => 'default_approval_registration_form'],
            [
                'label'       => 'Default approval registration form',
                'description' => 'The standard registration form for all approval events by this company',
                'type'        => 'approval',
                'is_active'   => true,
            ]
        );
    }
}
