<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Dashboard extends Component
{
    public $events;

    public function mount(){
        $this->events = Event::where('active', true)->get();
    }

    public function render()
    {

        return view('livewire.backend.admin.dashboard', [
            'events' => $this->events
        ]);
    }
}