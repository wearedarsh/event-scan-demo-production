<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailBroadcast;
use App\Models\Event;

#[Layout('livewire.backend.admin.layouts.app')]
class Show extends Component
{
    use WithPagination;

    public Event $event;
    public EmailBroadcast $broadcast;

    public string $search = '';

    public function mount(Event $event, EmailBroadcast $broadcast)
    {
        $this->event = $event;
        $this->broadcast = $broadcast;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $sends = $this->broadcast->sends()
            ->with(['recipient'])
            ->withCount(['opens', 'clicks'])
            ->when($this->search, function ($q) {
                $q->where('email_address', 'like', "%{$this->search}%")
                  ->orWhereHas('recipient', function ($q) {
                      $q->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                  });
            })
            ->orderByDesc('sent_at')
            ->paginate(25);

        return view('livewire.backend.admin.emails.broadcasts.show', [
            'broadcast' => $this->broadcast,
            'sends'     => $sends,
        ]);
    }
}
