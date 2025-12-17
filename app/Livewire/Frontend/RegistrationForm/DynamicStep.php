<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\RegistrationFormStep;

class DynamicStep extends Component
{
    public RegistrationFormStep $step;

    public array $state = [];

    public function mount(RegistrationFormStep $step)
    {
        $this->step = $step;

        foreach ($step->inputs as $input) {
            $this->state[$input->key_name] = null;
        }
    }

    public function getSelectOptions($input): array
    {
        if ($input->relation_model) {
            $model = "App\\Models\\{$input->relation_model}";
            return $model::pluck('name', 'id')->toArray();
        }

        return collect($input->options ?? [])
            ->mapWithKeys(fn ($v) => [$v => $v])
            ->toArray();
    }

    public function submitStep()
    {
        $rules = [];
        foreach ($this->step->inputs as $input) {
            if ($input->required) {
                $rules[$input->key_name] = ['required'];
            }
        }

        $this->validate($rules);

    }

    public function render()
    {
        return view('livewire.frontend.registration-form.dynamic-step');
    }
}
