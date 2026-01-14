<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm\Fields;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationFormStep;
use App\Models\RegistrationFormInput;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public RegistrationFormStep $step;
    public RegistrationFormInput $field;

    public string $label = '';
    public string $key_name = '';
    public string $type = 'text';
    public int $required = 0;
    public ?string $placeholder = null;
    public $allowed_file_types = null;

    public int $display_order = 1;
    public int $col_span = 12;
    public int $row_start = 0;
    public int $row_end = 0;

    public int $custom = 0;
    public ?string $relation_model = null;

    public string $validation_rules = '';
    public string $validation_messages = '';

    public function mount(RegistrationFormStep $step, RegistrationFormInput $field): void
    {
        $this->step  = $step;
        $this->field = $field;

        $this->label = $field->label;
        $this->key_name = $field->key_name;
        $this->type = $field->type;
        $this->required = (int) $field->required;
        $this->placeholder = $field->placeholder;

        $this->display_order = $field->display_order;
        $this->col_span = $field->col_span;
        $this->row_start = (int) $field->row_start;
        $this->row_end = (int) $field->row_end;
        $this->allowed_file_types = $field->allowed_file_types;

        $this->custom = (int) $field->custom;
        $this->relation_model = $field->relation_model;

        $this->validation_rules = $field->validation_rules
            ? json_encode($field->validation_rules, JSON_PRETTY_PRINT)
            : '';

        $this->validation_messages = $field->validation_messages
            ? json_encode($field->validation_messages, JSON_PRETTY_PRINT)
            : '';
    }

    public function update(): void
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

        $this->field->update([
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
            'validation_rules' => json_decode($this->validation_rules, true),
            'validation_messages' => $this->validation_messages
                ? json_decode($this->validation_messages, true)
                : null,
        ]);

        session()->flash('success', 'Field updated successfully.');

        redirect()->route(
            'admin.developer.registration-form.steps.manage',
            $this->step->id
        );
    }

    public function render()
    {
        return view('livewire.backend.admin.developer.registration-form.fields.edit');
    }
}
