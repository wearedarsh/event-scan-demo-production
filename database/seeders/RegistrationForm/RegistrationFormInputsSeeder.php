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
                'placeholder' => 'Select...',
                'type' => 'select',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => '3',
                'options' => [
                    ['value' => 'dr', 'label' => 'Dr'],
                    ['value' => 'mr', 'label' => 'Mr'],
                    ['value' => 'mrs', 'label' => 'Mrs'],
                    ['value' => 'ms', 'label' => 'Ms'],
                    ['value' => 'miss', 'label' => 'Miss'],
                    ['value' => 'professor', 'label' => 'Professor']
                ],
                'validation_rules' => ['required'],
                'validation_messages' => [
                    'required' => 'Please select a title'
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
                'row_start' => false,
                'row_end' => false,
                'col_span' => '4',
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your first name',
                    'string' => 'First name must be text only',
                    'max' => 'First name must be a maximum of 40 characters'
                ],
                'display_order' => 2
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'last_name',
                'label' => 'Last name',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => '5',
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your last name',
                    'string' => 'Last name must be text only',
                    'max' => 'Last name must be a maximum of 40 characters'
                ],
                'display_order' => 3
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'address_line_one',
                'label' => 'Address line 1',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => '12',
                'validation_rules' => ['required', 'string', 'max:50'],
                'validation_messages' => [
                    'required' => 'Please enter the first line of your address',
                    'string' => 'Address line one must be text only',
                    'max' => 'Address line one must be a maximum of 50 characters'
                ],
                'display_order' => 4
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'town',
                'label' => 'Town',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => '6',
                'validation_rules' => ['required', 'string', 'max:50'],
                'validation_messages' => [
                    'required' => 'Please enter your first name',
                    'string' => 'First name must be text only',
                    'max' => 'First name must be a maximum of 50 characters'
                ],
                'display_order' => 5
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'postcode',
                'label' => 'Postcode',
                'type' => 'text',
                'placeholder' => '',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => '6',
                'validation_rules' => ['required', 'string', 'max:12'],
                'validation_messages' => [
                    'required' => 'Please enter your postcode',
                    'string' => 'Postcode must be text only',
                    'max' => 'Postcode must be a maximum of 12 characters'
                ],
                'display_order' => 6
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'country_id',
                'label' => 'Country',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'relation_model' => 'App\Models\Country',
                'col_span' => '6',
                'validation_rules' => ['required', 'exists:countries,id'],
                'validation_messages' => [
                    'required' => 'Please select your country',
                    'exists' => 'Please select a valid country'
                ],
                'display_order' => 7
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'custom_field_one',
                'label' => 'My custom field',
                'type' => 'text',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => '6',
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your custom field',
                    'string' => 'Custom field can only be text',
                    'max' => 'Custom field must be a maximum of 40 characters'
                ],
                'display_order' => 8
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
                'row_start' => true,
                'row_end' => true,
                'col_span' => '12',
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your Currently held position',
                    'string' => 'Currently held position can only be text',
                    'max' => 'Currently held position must be a maximum of 40 characters'
                ],
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
                'row_start' => true,
                'row_end' => true,
                'col_span' => '12',
                'validation_rules' => ['nullable', 'exists:attendee_types:id'],
                'validation_messages' => [
                    'exists' => 'Please select a valid profession'
                ],
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
                'row_start' => true,
                'row_end' => true,
                'col_span' => '12',
                'validation_rules' => ['required_without:attendee_type_id', 'string', 'max:40'],
                'validation_messages' => [
                    'required_without' => 'Please enter your profession or select from the list'
                ],
                'display_order' => 3
            ],
        ];

        foreach ($professional_inputs as $professional_input){
            RegistrationFormInput::create($professional_input);
        }

    }
}
