<?php

namespace App\Livewire\Backend\Admin\Content;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventContent;
use Illuminate\Support\Facades\Log;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public EventContent $content;

    public string $title;
    public string $html_content = '';
    public int $active = 1;
    public int $order = 0;

    public function mount(Event $event, EventContent $content)
    {
        $this->event = $event;
        $this->content = $content;

        // Pre-fill form fields
        $this->title = $content->title;
        $this->html_content = $content->html_content;
        $this->active = $content->active;
        $this->order = $content->display_order;
    }

    public function logMessage($message)
    {
        Log::info($message);
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
            'order' => 'required|integer|min:0',
            'active' => 'boolean',
        ]);

        $this->content->update([
            'title' => $this->title,
            'html_content' => $this->html_content,
            'order' => $this->order,
            'active' => $this->active,
        ]);

        session()->flash('success', 'Content section updated successfully.');
        return redirect()->route('admin.events.content.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.content.edit', [
            'ck_apikey' => config('services.ckeditor.api_key')
        ]);
    }
}
