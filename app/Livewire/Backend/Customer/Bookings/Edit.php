<?php

namespace App\Livewire\Backend\Customer\Bookings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Registration;
use App\Models\AttendeeType;

#[Layout('livewire.backend.customer.layouts.app')]
class Edit extends Component
{
    public User $user;
    public Registration $registration;

    public string $mobile_country_code = '';
    public string $mobile_number = '';
    public string $address_line_one = '';
    public string $town = '';
    public string $postcode = '';
    public ?int $country_id = null;
    public string $currently_held_position = '';
    public ?int $attendee_type_id = null;

    public function mount(User $user, Registration $registration)
    {
        $this->user = $user;
        $this->registration = $registration;

        $this->mobile_country_code = $registration->mobile_country_code;
        $this->mobile_number = $registration->mobile_number;
        $this->address_line_one = $registration->address_line_one;
        $this->town = $registration->town;
        $this->postcode = $registration->postcode;
        $this->country_id = $registration->country_id;
        $this->currently_held_position = $registration->currently_held_position;
        $this->attendee_type_id = $registration->attendee_type_id;
    }

    public function rules()
    {
        return [
            'mobile_country_code' => 'nullable|string|max:10',
            'mobile_number' => 'nullable|string|max:20',
            'address_line_one' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:20',
            'country_id' => 'nullable|exists:countries,id',
            'currently_held_position' => 'nullable|string|max:255',
            'attendee_type_id' => 'nullable|exists:attendee_types,id',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->registration->update([
            'mobile_country_code' => $this->mobile_country_code,
            'mobile_number' => $this->mobile_number,
            'address_line_one' => $this->address_line_one,
            'town' => $this->town,
            'postcode' => $this->postcode,
            'country_id' => $this->country_id,
            'currently_held_position' => $this->currently_held_position,
            'attendee_type_id' => $this->attendee_type_id,
        ]);

        activity('registration')
            ->causedBy($this->user)
            ->performedOn($this->registration)
            ->log('Updated personal details for registration');

        session()->flash('success', 'Details updated successfully.');
        return redirect()->route('customer.bookings.manage', [
            'user' => $this->user->id,
            'registration' => $this->registration->id
        ]);
    }

    public function render()
    {
        return view('livewire.backend.customer.bookings.edit', [
            'attendeeTypes' => AttendeeType::where('active', true)->orderBy('name')->get()
        ]);
    }
}
