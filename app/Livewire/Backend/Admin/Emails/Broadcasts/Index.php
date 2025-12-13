<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailBroadcast;
use App\Models\EmailBroadcastType;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

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
        $base_query = EmailBroadcast::where('event_id', $this->event->id);

        $type_counts = $base_query
            ->clone()
            ->select('email_broadcast_type_id', DB::raw('count(*) as total'))
            ->groupBy('email_broadcast_type_id')
            ->pluck('total', 'email_broadcast_type_id');

        $sendCounts = $base_query
            ->clone()
            ->withCount('sends')
            ->get()
            ->groupBy(fn ($b) => $b->sends_count > 1 ? 'bulk' : 'single')
            ->map->count();

        $counts = [
            'all'    => $base_query->clone()->count(),
            'bulk'   => $sendCounts['bulk']   ?? 0,
            'single' => $sendCounts['single'] ?? 0,
        ] + $type_counts;

        $counts['all'] = $base_query->clone()->count();

        $query = $base_query
            ->withCount('sends')
            ->with(['type', 'sender']);

        match ($this->filter) {
            'bulk'   => $query->having('sends_count', '>', 1),
            'single' => $query->having('sends_count', '=', 1),
            default  => null,
        };

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
