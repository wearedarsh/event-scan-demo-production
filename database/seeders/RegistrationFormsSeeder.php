<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationForm;

class RegistrationFormsSeeder extends Seeder
{
    public function run()
    {
        RegistrationForm::updateOrCreate(
            ['id' => 1],
            [
                'label' => 'Default Company Registration Form',
                'key_name' => 'default_registration_form',
                'description' => 'The standard registration form for all events by this company',
                'is_active' => true,
            ]
        );
    }
}
