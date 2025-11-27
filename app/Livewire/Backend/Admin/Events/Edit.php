<?php

namespace App\Livewire\Backend\Admin\Events;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;

    public string $title;
    public string $location;
    public string $date_start;
    public string $date_end;
    public string $event_attendee_limit;
    public string $vat_percentage;
    public string $full = '0';
    public string $active = '1';
    public string $template = '1';
    public string $show_email_marketing_opt_in = '1';
    public string $auto_email_opt_in = '1';
    public string $email_list_id;
    public string $email_opt_in_description = '0';
    public string $provisional = '0';

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->title = $event->title;
        $this->location = $event->location;
        $this->date_start = Carbon::parse($event->date_start)->format('d-m-Y');
        $this->date_end   = Carbon::parse($event->date_end)->format('d-m-Y');
        $this->event_attendee_limit = $event->event_attendee_limit;
        $this->vat_percentage = $event->vat_percentage;
        $this->full = $event->full;
        $this->active = $event->active;
        $this->template = $event->template;
        $this->show_email_marketing_opt_in = $event->show_email_marketing_opt_in;
        $this->auto_email_opt_in = $event->auto_email_opt_in;
        $this->email_list_id = $event->email_list_id;
        $this->email_opt_in_description = $event->email_opt_in_description;
        $this->provisional = $event->provisional;
    }

    public function update()
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

        $this->event->update([
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

        session()->flash('success', 'Event updated successfully.');
        return redirect()->route('admin.events.manage', [
            'event' => $this->event->id
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.events.edit', [
        ]);
    }
}
