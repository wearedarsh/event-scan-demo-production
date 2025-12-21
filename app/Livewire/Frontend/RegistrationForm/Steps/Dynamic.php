<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;
use App\Models\Registration;
use App\Models\RegistrationFormCustomFieldValue;

class Dynamic extends Component
{
    public Event $event;
    public RegistrationFormStep $registration_form_step;
    public Registration $registration;

    public $inputs;
    public $form_data = [];

    protected $listeners = [
        'validate-step' => 'validateStep',
        'save-step' => 'saveStep',
    ];

    public function mount()
    {
        if ($this->registration_form_step) {
            $this->inputs = $this->registration_form_step->inputs;

            // preload form_data with existing registration values
            foreach ($this->inputs as $input) {
                $key = $input->key_name;

                if ($input->custom_field) {
                    $this->form_data[$key] = $this->registration
                        ->customFields()
                        ->where('custom_field_key', $key)
                        ->value('value') ?? '';
                } else {
                    $this->form_data[$key] = $this->registration->{$key} ?? '';
                }
            }
        }
    }

    public function validateStep()
    {
        $rules = [];
        $messages = [];

        foreach ($this->inputs as $input) {
            $key = 'form_data.' . $input->key_name;
            $rules[$key] = $input->validation_rules ?? [];

            $messages = array_merge(
                $messages,
                collect($input->validation_messages ?? [])
                    ->mapWithKeys(fn ($msg, $rule) => ["form_data.{$input->key_name}.{$rule}" => $msg])
                    ->toArray()
            );
        }

        $this->validate($rules, $messages);
    }

    public function saveStep()
    {
        // first validate
        $this->validateStep();

        foreach ($this->inputs as $input) {
            $key = $input->key_name;
            $value = $this->form_data[$key] ?? null;

            if ($input->custom_field) {
                // save or update custom field
                RegistrationFormCustomFieldValue::updateOrCreate(
                    [
                        'registration_id' => $this->registration->id,
                        'custom_field_key' => $key
                    ],
                    ['value' => $value]
                );
            } else {
                // save to main registration table
                $this->registration->{$key} = $value;
            }
        }

        $this->registration->save();

        // emit an event back to parent that step is saved
        $this->emitUp('dynamic-step-saved', $this->registration_form_step->id);
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
