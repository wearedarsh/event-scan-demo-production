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
    public string $filter = 'all'; // ← NEW

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
        $counts = [
            'all'   => EmailBroadcast::where('event_id', $this->event->id)->count(),
            'bulk'  => EmailBroadcast::where('event_id', $this->event->id)->has('sends', '>', 1)->count(),
            'single'=> EmailBroadcast::where('event_id', $this->event->id)->has('sends', '=', 1)->count(),
        ];

        $query = EmailBroadcast::query()
            ->where('event_id', $this->event->id)
            ->withCount('sends')
            ->with('type', 'sender');

        match ($this->filter) {
            'bulk'   => $query->has('sends', '>', 1),
            'single' => $query->has('sends', '=', 1),
            default  => null,
        };

        if ($this->search !== '') {
            $query->where('friendly_name', 'like', "%{$this->search}%");
        }

        $broadcasts = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.backend.admin.emails.broadcasts.index', [
            'broadcasts' => $broadcasts,
            'counts'     => $counts,
            'event'      => $this->event,
        ]);
    }
}
