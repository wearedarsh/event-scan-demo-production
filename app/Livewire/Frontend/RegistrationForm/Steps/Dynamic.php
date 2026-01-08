<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;


use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormCustomFieldValue;
use App\Models\Registration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Dynamic extends Component
{
    use WithFileUploads;
    public Event $event;
    public RegistrationFormStep $registration_form_step;
    public Registration $registration;

    public $current_step;

    public $inputs;
    public $form_data = [];
    public array $rules = [];
    public array $messages = [];
    public array $inputs_by_key = [];

    public array $document_uploads = [];
    public array $replace_document = [];


    protected $listeners = [
        'validate-step' => 'validateStep',
        'store' => 'store'
    ];

    public function mount()
    {

        $this->rules = [];
        $this->messages = [];

        if ($this->registration_form_step) {
            $this->inputs = $this->registration_form_step->inputs;
            $this->inputs_by_key = collect($this->inputs)->keyBy('key_name')->all();

            foreach($this->inputs as $input){

                if ($input->type === 'document_upload') {
                    $this->document_uploads[$input->id] = null;
                    continue;
                }

                if($input->custom){
                     $value = $this->registration->customFieldValues
                        ->firstWhere('registration_form_input_id', $input->id)?->value;

                    $this->form_data[$input->key_name] = $value ?? null;
                }else{
                    $this->form_data[$input->key_name] = $this->registration->{$input->key_name} ?? null;
                }

                
                foreach($input->validation_rules as $rule){
                    $this->rules['form_data.'.$input->key_name][] = $rule;
                }

                foreach($input->validation_messages as $rule => $message){
                    $this->messages['form_data.'.$input->key_name.'.'.$rule] = $message;
                }
            }
        }
    }

    protected function validateDocumentUploads(): void
    {
        foreach ($this->inputs as $input) {

            if ($input->type !== 'document_upload') continue;

            $existingDocument = $this->registration
                ->registrationDocuments
                ->firstWhere('registration_form_input_id', $input->id);

            $isReplacing = !empty($this->replace_document[$input->id]);
            $file = $this->document_uploads[$input->id] ?? null;

            if (($isReplacing || !$existingDocument) && $input->required && !$file) {
                $this->addError(
                    "document_uploads.{$input->id}",
                    "Please upload a document for {$input->label}."
                );
                continue;
            }

            if ($file) {
                $rules = ['file', 'max:5120'];

                if ($input->allowed_file_types) {
                    $rules[] = 'mimes:' . $input->allowed_file_types;
                }

                $this->validate([
                    "document_uploads.{$input->id}" => $rules,
                ]);
            }
        }
    }

    protected function persistDocumentUploads(): void
    {
        foreach ($this->document_uploads as $input_id => $file) {
            if (!$file) continue;

            $path = $file->store(
                "registrations/{$this->registration->id}/documents",
                'private'
            );

            $this->registration->registrationDocuments()->updateOrCreate(
                [
                    'registration_form_input_id' => $input_id,
                ],
                [
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]
            );

            unset($this->replace_document[$input_id]);
        }
    }
    
    protected function cleanupOrphanedDocuments(): void
    {
        $validInputIds = $this->inputs
            ->where('type', 'document_upload')
            ->pluck('id');

        $this->registration->registrationDocuments
            ->whereNotIn('registration_form_input_id', $validInputIds)
            ->each(function ($doc) {
                Storage::disk('private')->delete($doc->file_path);
                $doc->delete();
            });
    }



    public function rules()
    {
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
    }

    public function validateStep($direction)
    {
        $this->dispatch('scroll-to-top');
        $this->resetErrorBag();

        if ($direction === 'forward') {

            $this->validate();


            $this->validateDocumentUploads();

            if ($this->getErrorBag()->isNotEmpty()) {
                return;
            }

            $this->store();
            $this->persistDocumentUploads();
            $this->cleanupOrphanedDocuments();
        }

        $this->dispatch('update-step', $direction);
    }


    public function store(): void
    {
        $fields_to_update = [];
        $custom_fields_to_update = [];

        foreach ($this->form_data as $key => $value) {

            $input = $this->inputs_by_key[$key];

            if ($input->type === 'document_upload') {
                continue;
            }

            if ($input->custom) {
                $custom_fields_to_update[] = [
                    'id' => $input->id,
                    'value' => $value,
                ];
            } else {
                $fields_to_update[$key] = $value;
            }
        }

        if (!empty($fields_to_update)) {
            Registration::updateOrCreate(
                [
                    'id' => $this->registration->id,
                    'event_id' => $this->event->id,
                ],
                $fields_to_update
            );
        }

        foreach ($custom_fields_to_update as $custom_field) {
            RegistrationFormCustomFieldValue::updateOrCreate(
                [
                    'registration_id' => $this->registration->id,
                    'registration_form_input_id' => $custom_field['id'],
                ],
                [
                    'value' => $custom_field['value'],
                ]
            );
        }
    }


    
    public function getInputOptions($input)
    {
        if ($input->relation_model) {
            return app($input->relation_model)
                ->query()
                ->where('active', true)
                ->orderBy('name')
                ->get()
                ->map(fn ($model) => [
                    'value' => $model->id,
                    'label' => $model->name,
                ]);
        }

        return collect($input->options)
            ->map(fn ($option) => [
                'value' => $option['value'],
                'label' => $option['label'],
            ]);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.dynamic');
    }
}
