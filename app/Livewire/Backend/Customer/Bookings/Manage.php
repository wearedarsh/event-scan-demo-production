<?php

namespace App\Livewire\Backend\Customer\Bookings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Registration;
use App\Models\RegistrationOptInResponse;

#[Layout('livewire.backend.customer.layouts.app')]
class Manage extends Component
{
    public User $user;
    public Registration $registration;
    public $currency_symbol;
    
    public function mount(User $user, Registration $registration)
    {
        $this->user = $user;
        $this->registration = $registration;
        $this->currency_symbol = config('app.currency_symbol', '€');
    }

    public function updateOptIn($id)
    {
        $optInResponse = RegistrationOptInResponse::findOrFail($id);
        $optInResponse->value = !$optInResponse->value;
        $optInResponse->save();

        activity('marketing')
            ->causedBy($this->user)
            ->log('Updated registration opt in status');

        session()->flash('success', 'Opt-in status updated successfully.');
    }

    public function render()
    {
        return view('livewire.backend.customer.bookings.manage');
    }
}
