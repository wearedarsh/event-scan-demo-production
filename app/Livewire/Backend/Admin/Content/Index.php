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

    public function mount(Event $event){
        $this->event = $event;
    }

    public function delete(int $id)
    {
        $content = EventContent::findOrFail($id);
        $content->delete();
        session()->flash('success', 'Content deleted successfully.');
    }

    public function deleteDownload($id)
    {
        $download = EventDownload::findOrFail($id);
        $download->delete();

        session()->flash('success', 'Download deleted successfully.');
    }

    public function render()
    {
        return view('livewire.backend.admin.content.index', [
            'event' => $this->event,
            'downloads' => $this->event->downloads()->orderBy('display_order')->get()
        ]);
    }
}
