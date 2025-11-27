<?php

namespace App\Livewire\Backend\Admin\Attendees;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\Registration;
use App\Models\AttendeeType;
use App\Models\AttendeeGroup;

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

    // NEW
    public ?int $attendee_group_id = null;

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

        // NEW
        $this->attendee_group_id = $attendee->attendee_group_id;
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

            // NEW (nullable is fine)
            'attendee_group_id' => 'nullable|exists:attendee_groups,id',
        ];
    }

    public function update()
    {
        $this->validate();

        // Optional: ensure selected group belongs to this event (extra safety)
        if ($this->attendee_group_id) {
            $valid = $this->event->attendeeGroups()->whereKey($this->attendee_group_id)->exists();
            if (! $valid) {
                $this->addError('attendee_group_id', 'Invalid group for this event.');
                return;
            }
        }

        $this->attendee->update([
            'mobile_country_code' => $this->mobile_country_code,
            'mobile_number' => $this->mobile_number,
            'address_line_one' => $this->address_line_one,
            'town' => $this->town,
            'postcode' => $this->postcode,
            'country_id' => $this->country_id,
            'currently_held_position' => $this->currently_held_position,
            'attendee_type_id' => $this->attendee_type_id,

            // NEW
            'attendee_group_id' => $this->attendee_group_id,
        ]);

        session()->flash('success', 'Attendee updated successfully.');
        return redirect()->route('admin.events.attendees.manage', [
            'event' => $this->event->id,
            'attendee' => $this->attendee->id
        ]);
    }

    public function render()
    {
        $attendeeGroups = $this->event->attendeeGroups()
            ->get()
            ->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
        return view('livewire.backend.admin.attendees.edit', [
            'attendeeTypes' => AttendeeType::where('active', true)->orderBy('name')->get(),
            // NEW: list of groups for this event
            'attendeeGroups' => $attendeeGroups,
        ]);
    }
}
