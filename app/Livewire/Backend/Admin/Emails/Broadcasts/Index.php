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
    protected array $specialFilters = ['all', 'bulk', 'single'];

    public function mount(Event $event)
    {
        $this->event = $event;

        if (! $this->filter || $this->filter === 'all') {
            $firstCategory = EmailBroadcastTypeCategory::query()->first();
            $this->filter = $firstCategory
                ? 'all_category_'.$firstCategory->id
                : 'all';
        }
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
        $base_query = EmailBroadcast::where('event_id', $this->event->id)
            ->withCount('sends')
            ->with(['type', 'sender']);

        if (str_starts_with($this->filter, 'all_category_')) {
            $categoryId = (int) str_replace('all_category_', '', $this->filter);

            $base_query->whereHas('type', fn ($q) =>
                $q->where('category_id', $categoryId)
            );
        }
        elseif (is_numeric($this->filter)) {
            $base_query->where('email_broadcast_type_id', $this->filter);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $base_query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('sends', function ($q) use ($search) {
                        $q->whereRaw('(select count(*) from email_sends where email_sends.email_broadcast_id = email_broadcasts.id) = 1')
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

        $broadcasts = $base_query
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = EmailBroadcastTypeCategory::with(['types.broadcasts' => function ($q) {
            $q->withCount('sends');
        }])->get();

        $counts = [
            'all' => $base_query->clone()->count(),
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
