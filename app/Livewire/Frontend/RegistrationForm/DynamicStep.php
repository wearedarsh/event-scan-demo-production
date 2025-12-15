<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\RegistrationFormStep;

class DynamicStep extends Component
{
    public RegistrationFormStep $step;

    public array $state = [];

    public function getSelectOptions($input): array
    {
        if ($input->relation_model) {
            $model = "App\\Models\\{$input->relation_model}";
            return $model::pluck('name', 'id')->toArray();
        }

        if ($input->options) {
            return collect(explode(',', $input->options))
                ->map(fn ($v) => trim($v))
                ->mapWithKeys(fn ($v) => [$v => $v])
                ->toArray();
        }

        return [];
    }


    public function mount(RegistrationFormStep $step)
    {
        $this->step = $step;

        foreach ($step->inputs as $input) {
            $this->state[$input->key_name] = null;
        }
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.dynamic-step');
    }
}
