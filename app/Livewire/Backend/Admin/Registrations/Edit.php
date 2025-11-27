<?php

namespace App\Livewire\Backend\Admin\Registrations;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use App\Models\AttendeeType;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public Registration $attendee;

    public string $mobile_country_code = '';
    public string $mobile_number = '';
    public string $address_line_one = '';
    public string $town = '';
    public string $postcode = '';
    public ?int $country_id = null;
    public string $currently_held_position = '';
    public ?int $attendee_type_id = null;

    public function mount(Event $event, Registration $attendee)
    {
        $this->event = $event;
        $this->attendee = $attendee;

        $this->mobile_country_code = $attendee->mobile_country_code;
        $this->mobile_number = $attendee->mobile_number;
        $this->address_line_one = $attendee->address_line_one;
        $this->town = $attendee->town;
        $this->postcode = $attendee->postcode;
        $this->country_id = $attendee->country_id;
        $this->currently_held_position = $attendee->currently_held_position;
        $this->attendee_type_id = $attendee->attendee_type_id;
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

        $this->attendee->update([
            'mobile_country_code' => $this->mobile_country_code,
            'mobile_number' => $this->mobile_number,
            'address_line_one' => $this->address_line_one,
            'town' => $this->town,
            'postcode' => $this->postcode,
            'country_id' => $this->country_id,
            'currently_held_position' => $this->currently_held_position,
            'attendee_type_id' => $this->attendee_type_id,
        ]);


        session()->flash('success', 'Registration updated successfully.');
        return redirect()->route('admin.events.registrations.manage', [
            'event' => $this->event->id,
            'attendee' => $this->attendee->id
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.registrations.edit', [
            'attendeeTypes' => AttendeeType::where('active', true)->orderBy('name')->get()
        ]);
    }
}
