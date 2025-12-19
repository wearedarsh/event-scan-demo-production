<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationFormStep;

class Dynamic extends Component
{
    public Event $event;
    public RegistrationFormStep $registration_form_step;
    public $inputs;

    public function mount(){
        if($this->registration_form_step){
            $this->inputs = $this->registration_form_step->inputs;
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
