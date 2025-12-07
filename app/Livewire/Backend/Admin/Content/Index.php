<?php

namespace App\Livewire\Backend\Admin\Content;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventContent;
use App\Models\EventDownload;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public Event $event;

    public $orders = [
        'content' => [],
        'downloads' => [],
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->loadOrders();
    }

    private function loadOrders()
    {
        $this->orders['content'] = $this->event->contentAll
            ->pluck('order', 'id')
            ->toArray();

        $this->orders['downloads'] = EventDownload::where('event_id', $this->event->id)
            ->orderBy('display_order')
            ->pluck('display_order', 'id')
            ->toArray();
    }

    public function moveUpContent($id)
    {
        $current = EventContent::findOrFail($id);

        if ($current->order <= 1) {
            return;
        }

        $current->decrement('order');
        $this->loadOrders();
    }

    public function moveDownContent($id)
    {
        $current = EventContent::findOrFail($id);

        $current->increment('order');
        $this->loadOrders();
    }

    public function updateContentOrder($id)
    {
        if (!isset($this->orders['content'][$id])) {
            return;
        }

        $newOrder = max(1, (int) $this->orders['content'][$id]);

        EventContent::where('id', $id)->update([
            'order' => $newOrder
        ]);

        $this->loadOrders();
    }


    public function moveUpDownloads($id)
    {
        $current = EventDownload::findOrFail($id);

        if ($current->display_order <= 1) {
            return;
        }

        $current->decrement('display_order');
        $this->loadOrders();
    }

    public function moveDownDownloads($id)
    {
        $current = EventDownload::findOrFail($id);

        $current->increment('display_order');
        $this->loadOrders();
    }

    public function updateDownloadOrder($id)
    {
        if (!isset($this->orders['downloads'][$id])) {
            return;
        }

        $newOrder = max(1, (int) $this->orders['downloads'][$id]);

        EventDownload::where('id', $id)->update([
            'display_order' => $newOrder
        ]);

        $this->loadOrders();
    }

    public function deleteContent(int $id)
    {
        EventContent::findOrFail($id)->delete();

        session()->flash('success', 'Content deleted successfully.');
        $this->loadOrders();
    }

    public function deleteDownload(int $id)
    {
        EventDownload::findOrFail($id)->delete();

        session()->flash('success', 'Download deleted successfully.');
        $this->loadOrders();
    }


    public function render()
    {
        $allContent = EventContent::where('event_id', $this->event->id)->get();
        $allDownloads = EventDownload::where('event_id', $this->event->id)->get();

        $sortedContent = $allContent->sortBy(
            fn($c) => $this->orders['content'][$c->id] ?? $c->order
        );

        $sortedDownloads = $allDownloads->sortBy(
            fn($d) => $this->orders['downloads'][$d->id] ?? $d->display_order
        );

        return view('livewire.backend.admin.content.index', [
            'event' => $this->event,
            'event_contents' => $sortedContent,
            'downloads' => $sortedDownloads,
        ]);
    }
}
