<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;
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

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount()
    {
        $this->rules = [];
        $this->messages = [];

        if ($this->registration_form_step) {
            $this->inputs = $this->registration_form_step->inputs;

            foreach($this->inputs as $input){
                
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
            $tommmy;
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
