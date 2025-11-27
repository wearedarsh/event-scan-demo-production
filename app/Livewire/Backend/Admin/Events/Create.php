<?php

namespace App\Livewire\Backend\Admin\Events;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public string $title = '';
    public string $location = '';
    public string $date_start = '';
    public string $date_end = '';
    public string $event_attendee_limit = '';
    public string $vat_percentage = '20'; // sensible default?
    public string $full = '0';
    public string $active = '1';
    public string $template = '0';
    public string $show_email_marketing_opt_in = '1';
    public string $auto_email_opt_in = '1';
    public string $email_list_id = '';
    public string $email_opt_in_description = '';
    public string $provisional = '0';

    public function save()
    {
        $this->validate([
            'title'                     => 'required|string|max:255',
            'location'                  => 'required|string|max:255',
            'date_start'                => ['required', 'regex:/^\d{2}-\d{2}-\d{4}$/'],
            'date_end'                  => ['required', 'regex:/^\d{2}-\d{2}-\d{4}$/'],
            'event_attendee_limit'     => 'required|integer',
            'vat_percentage'            => 'required|numeric|min:0|max:100',
            'email_opt_in_description'  => 'required_if:show_email_marketing_opt_in,1|string'
        ]);

        $event = Event::create([
            'title'                         => $this->title,
            'location'                      => $this->location,
            'date_start'                    => Carbon::createFromFormat('d-m-Y', $this->date_start),
            'date_end'                      => Carbon::createFromFormat('d-m-Y', $this->date_end),
            'event_attendee_limit'         => $this->event_attendee_limit,
            'vat_percentage'                => $this->vat_percentage,
            'email_opt_in_description'      => $this->email_opt_in_description ?? null,
            'active'                        => (bool) $this->active,
            'full'                          => (bool) $this->full,
            'template'                      => (bool) $this->template,
            'show_email_marketing_opt_in'   => (bool) $this->show_email_marketing_opt_in,
            'provisional'                   => (bool) $this->provisional,
            'auto_email_opt_in'             => (bool) $this->auto_email_opt_in,
        ]);

        session()->flash('success', 'Event created successfully.');

        return redirect()->route('admin.events.manage', [
            'event' => $event->id
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.events.create');
    }
}
