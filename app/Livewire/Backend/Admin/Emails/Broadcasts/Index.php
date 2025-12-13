<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailBroadcast;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public Event $event;

    public string $search = '';
    public string $filter = 'all';

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter(string $filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {

        

        return view('livewire.backend.admin.emails.broadcasts.index', [
            'event'      => $this->event,
        ]);
    }
}
