<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;

class CheckoutSuccess extends Component
{
    public Event $event;
    public $registration_id;
    public $registration;
    public $events;


    public function mount($registration_id, Event $event)
    {
        $this->registration_id = $registration_id;
        $this->event = $event;
        $this->registration = Registration::find($this->registration_id);

    }

    public function clearLocalStorageAndRedirect(){
        $this->dispatch('removeFromLocalStorageAndRedirect');
    }
    
    public function render()
    {

        $this->events = Event::where('active', true)
            ->orderBy('date_start', 'asc')->get();

        return view('livewire.frontend.checkout-success')->extends('livewire.frontend.layouts.app', [
                'page_title' => 'Payment successful',
                'events' => $this->events,
                'event' => $this->event

            ]);
    }
}
