<?php

namespace Database\Seeders\RegistrationForm;

use Illuminate\Database\Seeder;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormInput;

class RegistrationFormApprovalInputsSeeder extends Seeder
{
    public function run(): void
    {
        $form = RegistrationForm::where(
            'key_name',
            'default_approval_registration_form'
        )->firstOrFail();

        $form_id = $form->id;

        $personal_step = RegistrationFormStep::where('registration_form_id', $form_id)
            ->where('key_name', 'personal')
            ->firstOrFail();

        $professional_step = RegistrationFormStep::where('registration_form_id', $form_id)
            ->where('key_name', 'professional')
            ->firstOrFail();

        $documents_step = RegistrationFormStep::where('registration_form_id', $form_id)
            ->where('key_name', 'documents')
            ->firstOrFail();

        $personal_inputs = [
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'title',
                'label' => 'Title',
                'type' => 'select',
                'placeholder' => 'Select...',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => 3,
                'options' => [
                    ['value' => 'Dr', 'label' => 'Dr'],
                    ['value' => 'Mr', 'label' => 'Mr'],
                    ['value' => 'Mrs', 'label' => 'Mrs'],
                    ['value' => 'Ms', 'label' => 'Ms'],
                    ['value' => 'Miss', 'label' => 'Miss'],
                    ['value' => 'Professor', 'label' => 'Professor'],
                ],
                'validation_rules' => ['required'],
                'validation_messages' => [
                    'required' => 'Please select a title',
                ],
                'display_order' => 1,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'first_name',
                'label' => 'First name',
                'type' => 'text',
                'required' => true,
                'row_start' => false,
                'row_end' => false,
                'col_span' => 4,
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your first name',
                ],
                'display_order' => 2,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'last_name',
                'label' => 'Surname',
                'type' => 'text',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => 5,
                'validation_rules' => ['required', 'string', 'max:40'],
                'validation_messages' => [
                    'required' => 'Please enter your surname',
                ],
                'display_order' => 3,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'mobile_country_code',
                'label' => 'Mobile country code',
                'type' => 'text',
                'placeholder' => 'eg +44',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => 4,
                'validation_rules' => ['required', 'regex:/^\+?[0-9]{1,5}$/'],
                'validation_messages' => [
                    'required' => 'Please enter your country code',
                ],
                'display_order' => 4,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'mobile_number',
                'label' => 'Mobile',
                'type' => 'text',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => 8,
                'validation_rules' => ['required'],
                'validation_messages' => [
                    'required' => 'Please enter your mobile number',
                ],
                'display_order' => 5,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'address_line_one',
                'label' => 'Home address line 1',
                'type' => 'text',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'validation_rules' => ['required', 'string', 'max:50'],
                'validation_messages' => [
                    'required' => 'Please enter your address line 1',
                ],
                'display_order' => 6,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'postcode',
                'label' => 'Home postcode',
                'type' => 'text',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => 6,
                'validation_rules' => ['required', 'string', 'max:12'],
                'validation_messages' => [
                    'required' => 'Please enter your postcode',
                ],
                'display_order' => 7,
            ],
            [
                'registration_form_step_id' => $personal_step->id,
                'key_name' => 'country_id',
                'label' => 'Home country',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => 6,
                'relation_model' => 'App\Models\Country',
                'validation_rules' => ['required', 'exists:countries,id'],
                'validation_messages' => [
                    'required' => 'Please select a country',
                ],
                'display_order' => 8,
            ],
        ];

        foreach ($personal_inputs as $input) {
            RegistrationFormInput::create($input);
        }

        $professional_inputs = [
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'work_address_line_one',
                'label' => 'Work address line 1',
                'type' => 'text',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'validation_rules' => ['required', 'string', 'max:50'],
                'validation_messages' => [
                    'required' => 'Please enter your work address line one',
                ],
                'display_order' => 1,
                'custom' => true,
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'work_postcode',
                'label' => 'Work postcode',
                'type' => 'text',
                'required' => true,
                'row_start' => true,
                'row_end' => false,
                'col_span' => 6,
                'validation_rules' => ['required', 'string', 'max:12'],
                'validation_messages' => [
                    'required' => 'Please enter your work postcode',
                ],
                'display_order' => 2,
                'custom' => true,
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'work_country_id',
                'label' => 'Work country',
                'type' => 'select',
                'required' => true,
                'row_start' => false,
                'row_end' => true,
                'col_span' => 6,
                'relation_model' => 'App\Models\Country',
                'validation_rules' => ['required', 'exists:countries,id'],
                'validation_messages' => [
                    'required' => 'Please select your work country',
                ],
                'display_order' => 3,
                'custom' => true,
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'attendee_type_id',
                'label' => 'Professional speciality',
                'type' => 'select',
                'placeholder' => 'Please select...',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'relation_model' => 'App\Models\AttendeeType',
                'validation_rules' => ['required_without:form_data.attendee_type_other'],
                'validation_messages' => [
                    'required_without' => 'Please select your professional speciality or enter it below',
                ],
                'display_order' => 4,
            ],
            [
                'registration_form_step_id' => $professional_step->id,
                'key_name' => 'highest_qualification',
                'label' => 'Highest academic qualification',
                'type' => 'select',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'options' => [
                    ['value' => 'PhD', 'label' => 'PhD'],
                    ['value' => 'MD', 'label' => 'MD'],
                    ['value' => 'BSc', 'label' => 'BSc'],
                    ['value' => 'BA', 'label' => 'BA'],
                    ['value' => 'Masters', 'label' => 'Masters'],
                ],
                'validation_rules' => ['required'],
                'validation_messages' => [
                    'required' => 'Please select your highest academic qualification',
                ],
                'display_order' => 5,
                'custom' => true,
            ],
        ];

        foreach ($professional_inputs as $input) {
            RegistrationFormInput::create($input);
        }
        
        $document_inputs = [
            [
                'registration_form_step_id' => $documents_step->id,
                'key_name' => 'cv_document',
                'label' => 'Curriculum Vitae (CV)',
                'type' => 'document_upload',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'validation_rules' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
                'validation_messages' => [
                    'required' => 'Please upload your Curriculum Vitae in pdf, doc or docx format',
                    'file' => 'Please upload a file',
                    'mimes' => 'Please upload your Curriculum Vitae in pdf, doc or docx format',
                    'max' => 'Please upload a file that is under 10mb'
                ],
                'display_order' => 1,
                'custom' => true,
            ],
            [
                'registration_form_step_id' => $documents_step->id,
                'key_name' => 'proof_of_address',
                'label' => 'Proof of address',
                'type' => 'document_upload',
                'required' => true,
                'row_start' => true,
                'row_end' => true,
                'col_span' => 12,
                'validation_rules' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
                'validation_messages' => [
                    'required' => 'Please upload your proof of address in pdf, doc or docx format',
                    'file' => 'Please upload a file',
                    'mimes' => 'Please upload your proof of address in pdf, doc or docx format',
                    'max' => 'Please upload a file that is under 10mb'
                ],
                'display_order' => 2,
                'custom' => true,
            ],
        ];

        foreach ($document_inputs as $input) {
            RegistrationFormInput::create($input);
        }
    }
}
