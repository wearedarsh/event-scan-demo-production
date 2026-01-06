<?php

namespace App\Livewire\Backend\Admin\Developer\RegistrationForm;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.developer.registration-form.index');
    }
}
