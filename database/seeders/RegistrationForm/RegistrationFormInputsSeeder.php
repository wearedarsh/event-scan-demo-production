<?php

namespace Database\Seeders\RegistrationForm;

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
                'col_span' => '2',
                'options' => [
                    ['value' => 'dr', 'label' => 'Dr'],
                    ['value' => 'mr', 'label' => 'Mr'],
                    ['value' => 'mrs', 'label' => 'Mrs'],
                    ['value' => 'ms', 'label' => 'Ms'],
                    ['value' => 'miss', 'label' => 'Miss'],
                    ['value' => 'professor', 'label' => 'Professor']
                ],
                'display_order' => 1
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'first_name',
                'label' => 'First name',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'col_span' => '4',
                'display_order' => 2
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'last_name',
                'label' => 'Last name',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'col_span' => '4',
                'display_order' => 3
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'address_line_one',
                'label' => 'Address line 1',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'col_span' => '12',
                'display_order' => 4
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'town',
                'label' => 'Town',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'col_span' => '6',
                'display_order' => 5
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'postcode',
                'label' => 'Postcode',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'col_span' => '6',
                'display_order' => 6
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'country_id',
                'label' => 'Country',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'required' => true,
                'relation_model' => 'App\Models\Country',
                'col_span' => '6',
                'display_order' => 7
            ],
        ];

        foreach ($personal_inputs as $personal_input){
            RegistrationFormInput::create($personal_input);
        }

        $professional_inputs = [
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'currently_held_position',
                'label' => 'Currently held position',
                'type' => 'text',
                'placeholder' => 'Company name',
                'required' => true,
                'col_span' => '12',
                'display_order' => 1
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'attendee_type_id',
                'label' => 'Profession',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'relation_model' => 'App\Models\AttendeeType',
                'required' => true,
                'col_span' => '12',
                'display_order' => 2
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'attendee_type_other',
                'label' => 'Other',
                'type' => 'text',
                'help' => 'Please enter your profession if it is not listed above',
                'placeholder' => '',
                'required' => false,
                'col_span' => '12',
                'display_order' => 3
            ],
        ];

        foreach ($professional_inputs as $professional_input){
            RegistrationFormInput::create($professional_input);
        }

    }
}
