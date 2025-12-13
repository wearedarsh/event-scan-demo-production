<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailBroadcast;
use App\Models\EmailBroadcastType;
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

    use Illuminate\Support\Facades\DB;

    public function render()
    {
        // Base query
        $baseQuery = EmailBroadcast::where('event_id', $this->event->id);

        // Counts per type
        $counts = $baseQuery
            ->clone()
            ->select('email_broadcast_type_id', DB::raw('count(*) as total'))
            ->groupBy('email_broadcast_type_id')
            ->pluck('total', 'email_broadcast_type_id');

        // All count
        $counts['all'] = $baseQuery->clone()->count();

        // Main list query
        $query = $baseQuery
            ->withCount('sends')
            ->with(['type', 'sender']);

        if ($this->filter !== 'all') {
            $query->where('email_broadcast_type_id', $this->filter);
        }

        if ($this->search !== '') {
            $query->where('friendly_name', 'like', "%{$this->search}%");
        }

        $broadcasts = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.backend.admin.emails.broadcasts.index', [
            'broadcasts' => $broadcasts,
            'counts'     => $counts,
            'types'      => EmailBroadcastType::all(),
            'event'      => $this->event,
        ]);
    }
}
