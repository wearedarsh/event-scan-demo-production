<?php

namespace App\Livewire\Backend\Admin\Website;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.backend.admin.website.index');
    }
}
