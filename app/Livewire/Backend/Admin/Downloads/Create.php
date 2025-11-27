<?php

namespace App\Livewire\Backend\Admin\Downloads;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\EventDownload;
use Livewire\Attributes\Validate;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    use WithFileUploads;
    public Event $event;
    public string $title = '';

    #[Validate('file|mimes:jpg,jpeg,png,pdf|max:20480')]
    public $file;

    public int $display_order = 0;
    public string $active = '0';

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function store()
    {

        $this->validate([
            'title' => 'required|string|max:255',
            'display_order' => 'required|integer|min:0',
        ]);

        $path = $this->file->store('event-downloads', 'public');

        EventDownload::create([
            'event_id' => $this->event->id,
            'title' => $this->title,
            'file_name' => $this->file->getClientOriginalName(),
            'file_path' => $path,
            'active' => (bool) $this->active,
            'file_type' => $this->file->getMimeType(),
            'file_size' => $this->file->getSize(),
            'display_order' => $this->display_order,
        ]);

        session()->flash('success', 'Download created successfully.');
        return redirect()->route('admin.events.content.index', $this->event->id);
    }

    public function render()
    {
        return view('livewire.backend.admin.downloads.create');
    }
}
