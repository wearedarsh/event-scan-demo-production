<?php

namespace App\Livewire\Backend\Admin\Content;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventContent;
use App\Models\EventDownload;
use App\Traits\HandlesDisplayOrder;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    use HandlesDisplayOrder;

    public Event $event;

    public array $orders = [
        'content' => [],
        'downloads' => [],
    ];

    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->loadOrders();
    }

    protected function loadOrders(): void
    {
        $this->orders['content'] = $this->event->contentAll
            ->pluck('display_order', 'id')
            ->toArray();

        $this->orders['downloads'] = EventDownload::where('event_id', $this->event->id)
            ->pluck('display_order', 'id')
            ->toArray();
    }


    public function moveContentUp(int $id): void
    {
        $this->moveUp(EventContent::findOrFail($id));
        $this->loadOrders();
    }

    public function moveContentDown(int $id): void
    {
        $this->moveDown(EventContent::findOrFail($id));
        $this->loadOrders();
    }

    public function updateContentOrder(int $id): void
    {
        if (!isset($this->orders['content'][$id])) {
            return;
        }

        $this->updateOrder(
            EventContent::findOrFail($id),
            (int) $this->orders['content'][$id]
        );

        $this->loadOrders();
    }


    public function moveDownloadUp(int $id): void
    {
        $this->moveUp(EventDownload::findOrFail($id));
        $this->loadOrders();
    }

    public function moveDownloadDown(int $id): void
    {
        $this->moveDown(EventDownload::findOrFail($id));
        $this->loadOrders();
    }

    public function updateDownloadOrder(int $id): void
    {
        if (!isset($this->orders['downloads'][$id])) {
            return;
        }

        $this->updateOrder(
            EventDownload::findOrFail($id),
            (int) $this->orders['downloads'][$id]
        );

        $this->loadOrders();
    }

    public function deleteContent(int $id): void
    {
        EventContent::findOrFail($id)->delete();
        session()->flash('success', 'Content deleted successfully.');
        $this->loadOrders();
    }

    public function deleteDownload(int $id): void
    {
        EventDownload::findOrFail($id)->delete();
        session()->flash('success', 'Download deleted successfully.');
        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.backend.admin.content.index', [
            'event' => $this->event,
            'event_contents' => EventContent::where('event_id', $this->event->id)
                ->get()
                ->sortBy(fn ($c) => $this->orders['content'][$c->id] ?? $c->display_order),

            'downloads' => EventDownload::where('event_id', $this->event->id)
                ->get()
                ->sortBy(fn ($d) => $this->orders['downloads'][$d->id] ?? $d->display_order),
        ]);
    }
}
