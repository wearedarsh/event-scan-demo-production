<?php

namespace App\Livewire\Backend\Customer\Bookings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('livewire.backend.customer.layouts.app')]
class Index extends Component
{
    public User $user;
    public string $currency_symbol;
    public $feedback_forms;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->currency_symbol = config('app.currency_symbol', '€');
    }

    public function render()
    {
        return view('livewire.backend.customer.bookings.index');
    }
}
