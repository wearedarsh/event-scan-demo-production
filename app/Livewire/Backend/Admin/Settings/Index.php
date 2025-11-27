<?php

namespace App\Livewire\Backend\Admin\Settings;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.settings.index');
    }
}
