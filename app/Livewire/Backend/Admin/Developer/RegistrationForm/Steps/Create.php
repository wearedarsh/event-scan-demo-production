<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm\Steps;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;
use Illuminate\Support\Str;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public RegistrationForm $form;

    public string $label = '';
    public string $key_name = '';
    public int $display_order = 1;

    public function mount(RegistrationForm $form): void
    {
        $this->form = $form;

        $this->display_order = ($form->steps()->max('display_order') ?? 0) + 1;
    }

    protected function rules(): array
    {
        return [
            'label'         => ['required', 'string', 'max:255'],
            'key_name'      => ['required', 'string'],
            'display_order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function create(): void
    {
        $this->validate();

        $isDynamic = $this->key_name === 'dynamic';

        RegistrationFormStep::create([
            'registration_form_id' => $this->form->id,
            'label'         => $this->label,
            'key_name'      => $isDynamic
                ? Str::slug($this->label, '_')
                : $this->key_name,
            'type'          => $isDynamic ? 'dynamic' : 'rigid',
            'display_order' => $this->display_order,
        ]);

        session()->flash('success', 'Step created successfully.');

        $this->redirect(
            route('admin.developer.registration-form.manage', $this->form->id)
        );
    }

    public function render()
    {
        return view('livewire.backend.admin.developer.registration-form.steps.create', [
            'form' => $this->form,
        ]);
    }
}
