<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm\Fields;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormInput;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public RegistrationFormStep $step;

    public string $label = '';
    public string $key_name = '';
    public string $type = 'text';
    public bool $required = false;
    public ?string $placeholder = null;

    public int $display_order = 1;
    public int $col_span = 12;
    public bool $row_start = true;
    public bool $row_end = true;

    public bool $custom = false;
    public ?string $relation_model = null;

    public array $options = [];
    public array $validation_rules = [];

    public function mount(RegistrationFormStep $step): void
    {
        $this->step = $step;

        $this->display_order =
            ($step->inputs()->max('display_order') ?? 0) + 1;
    }

    public function store(): void
    {
        $this->validate([
            'label' => 'required|string|max:255',
            'key_name' => 'required|string|max:255|alpha_dash',
            'type' => 'required|string',
            'display_order' => 'required|integer|min:1',
            'col_span' => 'required|integer|min:1|max:12',
            'relation_model' => 'nullable|string',
        ]);

        RegistrationFormInput::create([
            'registration_form_step_id' => $this->step->id,
            'label' => $this->label,
            'key_name' => $this->key_name,
            'type' => $this->type,
            'required' => $this->required,
            'placeholder' => $this->placeholder,
            'display_order' => $this->display_order,
            'col_span' => $this->col_span,
            'row_start' => $this->row_start,
            'row_end' => $this->row_end,
            'custom' => $this->custom,
            'relation_model' => $this->relation_model,
            'options' => $this->options ?: null,
            'validation_rules' => $this->validation_rules ?: null,
        ]);

        session()->flash('success', 'Field created successfully.');

        redirect()->route(
            'admin.developer.registration-form.steps.manage',
            $this->step->id
        );
    }

    public function render()
    {
        return view('livewire.backend.admin.developer.registration-form.fields.create');
    }
}
