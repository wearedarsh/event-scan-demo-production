<?php

namespace App\Livewire\Backend\Admin\Downloads;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Event;
use App\Models\EventDownload;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public EventDownload $download;

    public string $title;
    public int $display_order = 0;
    public string $active = '0';

    public function mount(Event $event, EventDownload $download)
    {
        $this->event = $event;
        $this->download = $download;
        $this->title = $download->title;
        $this->active = $download->active;
        $this->display_order = $download->display_order;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'display_order' => 'required|integer|min:0',
        ]);

        $this->download->update([
            'title' => $this->title,
            'display_order' => $this->display_order,
            'active' => (bool) $this->active
        ]);

        session()->flash('success', 'Download updated successfully.');
        return redirect()->route('admin.events.content.index', $this->event->id);
    }

    public function render()
    {
        return view('livewire.backend.admin.downloads.edit');
    }
}
