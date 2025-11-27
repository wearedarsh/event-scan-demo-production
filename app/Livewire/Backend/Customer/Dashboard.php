<?php

namespace App\Livewire\Backend\Customer;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

#[Layout('livewire.backend.customer.layouts.app')]
class Dashboard extends Component
{

    public function render()
    {
        return view('livewire.backend.customer.dashboard');
    }
}