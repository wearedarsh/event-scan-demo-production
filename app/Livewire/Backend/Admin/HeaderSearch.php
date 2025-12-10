<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;

class HeaderSearch extends Component
{
    public $query = '';

    public function render()
    {
        $results = [
            'events' => collect(),
            'attendees' => collect(),
            'registrations' => collect(),
            'users' => collect(),
        ];

        if (strlen($this->query) > 1) {

            $results['events'] = Event::where('title', 'LIKE', "%{$this->query}%")
                ->limit(5)
                ->get();

            $results['attendees'] = Registration::paid()
            ->where(function ($q) {
                $q->where('first_name', 'LIKE', "%{$this->query}%")
                ->orWhere('last_name', 'LIKE', "%{$this->query}%")
                ->orWhere('email', 'LIKE', "%{$this->query}%")
                ->orWhere('booking_reference', 'LIKE', "%{$this->query}%");
            })
            ->limit(5)
            ->get();


            $results['registrations'] = Registration::unpaidComplete()
            ->whereNotNull('event_payment_method_id')
                ->where(function ($q) {
                    $q->where('first_name', 'LIKE', "%{$this->query}%")
                        ->orWhere('last_name', 'LIKE', "%{$this->query}%")
                        ->orWhere('email', 'LIKE', "%{$this->query}%")
                        ->orWhere('booking_reference', 'LIKE', "%{$this->query}%");
                })
                    ->limit(5)
                    ->get();


            $results['users'] = User::where('active', true)
                ->where(function ($q) {
                    $q->where('first_name', 'LIKE', "%{$this->query}%")
                        ->orWhere('last_name', 'LIKE', "%{$this->query}%")
                        ->orWhere('email', 'LIKE', "%{$this->query}%");
                })
                ->limit(5)
                ->get();
        }


        return view('livewire.backend.admin.header-search', [
            'results' => $results
        ]);
    }

    public function resultUrl($type, $item)
    {
        return match ($type) {
            'events' => route('admin.events.manage', $item->id),

            'attendees' => route('admin.events.attendees.manage', ['event' => $item->event, 'attendee' => $item->id]),

            'registrations' => route('admin.events.registrations.manage', ['event' => $item->event, 'attendee' => $item->id]),

            'users' => route('admin.users.edit', $item->id),

            default => '#'
        };
    }
}
