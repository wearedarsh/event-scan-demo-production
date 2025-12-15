<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormInput;

class RegistrationFormInputsSeeder extends Seeder
{
    public function run()
    {
        $form_id = 1;

        // Fetch step IDs
        $personal_step = RegistrationFormStep::where('registration_form_id', $form_id)
            ->where('key_name', 'personal')
            ->first();

        $professional_step = RegistrationFormStep::where('registration_form_id', $form_id)
            ->where('key_name', 'professional')
            ->first();

        // Personal Details Inputs
        $personal_inputs = [
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'title',
                'label' => 'Title',
                'placeholder' => 'Please select...',
                'type' => 'select',
                'required' => true,
                'width' => '1/2',
                'options' => 'Dr, Mr, Mrs, Ms, Miss, Professor',
                'display_order' => 1
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'first_name',
                'label' => 'First name',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'width' => '1/2',
                'display_order' => 2
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'last_name',
                'label' => 'Last name',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'width' => '1/2',
                'display_order' => 3
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'address_line_one',
                'label' => 'Address line 1',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'width' => 'full',
                'display_order' => 4
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'town',
                'label' => 'Town',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'width' => '1/2',
                'display_order' => 5
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'postcode',
                'label' => 'Postcode',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'width' => '1/2',
                'display_order' => 6
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'country_id',
                'label' => 'Country',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'options' => '',
                'required' => true,
                'relation_model' => 'Country',
                'width' => 'full',
                'display_order' => 7
            ],
        ];

        RegistrationFormInput::insert($personal_inputs);

        $professional_inputs = [
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'currently_held_position',
                'label' => 'Currently held position',
                'type' => 'text',
                'placeholder' => 'Company name',
                'required' => true,
                'width' => 'full',
                'display_order' => 1
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'attendee_type_id',
                'label' => 'Profession',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'options' => '',
                'relation_model' => 'AttendeeType',
                'required' => true,
                'width' => 'full',
                'display_order' => 2
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'attendee_type_other',
                'label' => 'Other (if profession not listed)',
                'type' => 'text',
                'placeholder' => '',
                'required' => false,
                'width' => 'full',
                'display_order' => 3
            ],
        ];

        RegistrationFormInput::insert($professional_inputs);

    }
}
