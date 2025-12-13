<?php

namespace App\Livewire\Backend\Admin\Emails\Broadcasts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\EmailBroadcast;
use App\Models\EmailBroadcastTypeCategory;
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
        $query = EmailBroadcast::where('event_id', $this->event->id)
            ->withCount('sends')
            ->with(['type.category', 'sender']);

        if ($this->filter !== 'all') {
            $query->where('email_broadcast_type_id', $this->filter);
        }

        if ($this->search !== '') {
            $search = $this->search;

            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('sends', function ($q) use ($search) {
                        $q->whereRaw(
                            '(select count(*) from email_sends where email_sends.email_broadcast_id = email_broadcasts.id) = 1'
                        )
                            ->where(function ($q) use ($search) {
                                $q->where('email_address', 'like', "%{$search}%")
                                    ->orWhereHas('recipient', function ($q) use ($search) {
                                        $q->where('first_name', 'like', "%{$search}%")
                                            ->orWhere('last_name', 'like', "%{$search}%");
                                    });
                            });
                    });
            });
        }

        $broadcasts = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = EmailBroadcastTypeCategory::with([
            'types.broadcasts' => fn($q) =>
            $q->where('event_id', $this->event->id)
        ])->get();

        $counts = [
            'all' => EmailBroadcast::where('event_id', $this->event->id)->count(),
        ];

        foreach ($categories as $category) {
            foreach ($category->types as $type) {
                $counts[$type->id] = $type->broadcasts->count();
            }
        }

        return view('livewire.backend.admin.emails.broadcasts.index', [
            'broadcasts' => $broadcasts,
            'categories' => $categories,
            'counts'     => $counts,
            'event'      => $this->event,
            'filter'     => $this->filter,
        ]);
    }
}
