<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\RegistrationForm;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        $forms = RegistrationForm::query()
            ->withCount('steps')
            ->orderBy('type')
            ->orderBy('label')
            ->get();

        return view('livewire.backend.admin.developer.registration-form.index', [
            'forms' => $forms,
        ]);
    }
}
