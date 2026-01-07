<?php

namespace Database\Seeders\RegistrationForm;

use Illuminate\Database\Seeder;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;

class RegistrationFormApprovalStepsSeeder extends Seeder
{
    public function run()
    {
        $form = RegistrationForm::where('key_name', 'default_approval_registration_form')->first();
        $steps = [
            [
                'registration_form_id' => $form->id,
                'label' => 'Personal details',
                'key_name' => 'personal',
                'type' => 'dynamic',
                'display_order' => 1,
            ],
            [
                'registration_form_id' => $form->id,
                'label' => 'Professional details',
                'key_name' => 'professional',
                'type' => 'dynamic',
                'display_order' => 2,
            ],
            [
                'registration_form_id' => $form->id,
                'label' => 'Documents',
                'key_name' => 'documents',
                'type' => 'dynamic',
                'display_order' => 3,
            ],
            [
                'registration_form_id' => $form->id,
                'label' => 'Account creation',
                'key_name' => 'account',
                'type' => 'rigid',
                'display_order' => 4,
            ],
            [
                'registration_form_id' => $form->id,
                'label' => 'GDPR & Marketing preferences',
                'key_name' => 'gdpr',
                'type' => 'rigid',
                'display_order' => 5,
            ]
        ];

        RegistrationFormStep::insert($steps);
    }
}
