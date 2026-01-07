<?php

namespace App\Livewire\Backend\Admin\Content;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Event;
use App\Models\EventContent;

use Illuminate\Support\Facades\Log;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;

    public string $title;
    public string $html_content = '';
    public int $active = 1;
    public int $order = 0;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function logMessage($message)
    {
        Log::info($message);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
            'display_order' => 'required|integer|min:0',
            'active' => 'boolean',
        ]);

        EventContent::create([
            'event_id' => $this->event->id,
            'title' => $this->title,
            'html_content' => $this->html_content,
            'display_order' => $this->order,
            'active' => $this->active,
        ]);

        session()->flash('success', 'Content section created successfully.');
        return redirect()->route('admin.events.content.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.content.create', [
            'ck_apikey' => config('services.ckeditor.api_key')
        ]);
    }
}
