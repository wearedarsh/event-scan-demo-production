<?php

namespace App\Livewire\Backend\Admin\Downloads;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\EventDownload;
use Illuminate\Support\Facades\Storage;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    use WithFileUploads;

    public Event $event;
    public EventDownload $download;

    public string $title = '';
    public int $display_order = 0;
    public string $active = '0';

    // New file optional
    public $new_file;

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
            'new_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:20480',
        ]);

        // If a replacement file has been uploaded
        if ($this->new_file) {

            // Delete old file
            if ($this->download->file_path && Storage::disk('public')->exists($this->download->file_path)) {
                Storage::disk('public')->delete($this->download->file_path);
            }

            // Store the new file
            $path = $this->new_file->store('event-downloads', 'public');

            // Update file metadata
            $this->download->file_name = $this->new_file->getClientOriginalName();
            $this->download->file_path = $path;
            $this->download->file_type = $this->new_file->getMimeType();
            $this->download->file_size = $this->new_file->getSize();
        }

        $this->download->update([
            'title' => $this->title,
            'display_order' => $this->display_order,
            'active' => (bool) $this->active,
        ]);

        session()->flash('success', 'Download updated successfully.');
        return redirect()->route('admin.events.content.index', $this->event->id);
    }

    public function render()
    {
        return view('livewire.backend.admin.downloads.edit');
    }
}
