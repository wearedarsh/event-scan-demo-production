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
    public string $allowed_file_types = '';
    public int $required = 0;
    public ?string $placeholder = null;

    public int $display_order = 1;
    public int $col_span = 12;
    public int $row_start = 0;
    public int $row_end = 0;

    public int $custom = 0;
    public ?string $relation_model = null;

    public array $options = [];
    public string $validation_rules = '';
    public string $validation_messages = '';

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
            'validation_rules' => 'required|json',
            'validation_messages' => 'nullable|json',
            'allowed_file_types' => 'required_if:type,document_upload|string',
        ], [
            'allowed_file_types.required_if' =>
                'Please specify allowed file types for document uploads.',
        ]);

        RegistrationFormInput::create([
            'registration_form_step_id' => $this->step->id,
            'label' => $this->label,
            'key_name' => $this->key_name,
            'type' => $this->type,
            'required' => (bool) $this->required,
            'placeholder' => $this->placeholder,
            'display_order' => $this->display_order,
            'col_span' => $this->col_span,
            'row_start' => (bool) $this->row_start,
            'row_end' => (bool) $this->row_end,
            'custom' => (bool) $this->custom,
            'relation_model' => $this->relation_model,
            'allowed_file_types' => $this->allowed_file_types,
            'options' => $this->options ?: null,
            'validation_rules' => json_decode($this->validation_rules) ?: null,
            'validation_messages' => json_decode($this->validation_messages) ?: null
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
