<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormCustomFieldValue;
use App\Models\Registration;

class Dynamic extends Component
{
    public Event $event;
    public RegistrationFormStep $registration_form_step;
    public Registration $registration;

    public $current_step;

    public $inputs;
    public $form_data = [];
    public array $rules = [];
    public array $messages = [];
    public array $inputs_by_key = [];

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

                $input_value = null;

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
        $this->validate();
        $this->store();
        $this->dispatch('update-step', $direction);
    }

    public function store()
    {
        $fields_to_update = [];
        $custom_fields_to_update = [];

        foreach($this->form_data as $key => $value){
            if($this->inputs_by_key[$key]->custom){
                $custom_fields_to_update[$key]['value'] = $value;
                $custom_fields_to_update[$key]['id'] = $this->inputs_by_key[$key]->id;
            }else{
                $fields_to_update[$key] = $value;
            }
        }
        
        Registration::updateOrCreate(
            [
                'id' => $this->registration->id, 
                'event_id' => $this->event->id
            ],
            $fields_to_update
        );

        foreach($custom_fields_to_update as $custom_field){
            RegistrationFormCustomFieldValue::updateOrCreate(
                [
                    'registration_id' => $this->registration->id,
                    'registration_form_input_id' => $custom_field['id']
                ],
                [
                    'value' => $custom_field['value'
                ]
            ]);
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
