<?php

namespace App\Livewire\Backend\Admin\FeedbackForm;

use App\Models\FeedbackForm;
use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public FeedbackForm $feedback_form;
    public Event $event;
    public string $title;
    public int $active;
    public int $is_anonymous;
    public int $multi_step;

    public function mount(FeedbackForm $feedback_form, Event $event)
    {
        $this->feedback_form = $feedback_form;
        $this->event = $event;

        $this->title = $feedback_form->title;
        $this->active = (bool) $feedback_form->active;
        $this->is_anonymous = (bool) $feedback_form->is_anonymous;
        $this->multi_step = (bool) $feedback_form->multi_step;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'active' => 'required|boolean',
            'is_anonymous' => 'required|boolean',
            'multi_step' => 'required|boolean',
        ]);

        $this->feedback_form->update([
            'title' => $this->title,
            'active' => $this->active,
            'is_anonymous' => $this->is_anonymous,
            'multi_step' => $this->multi_step,
        ]);

        session()->flash('success', 'Feedback form updated');
        return redirect()->route('admin.events.feedback-form.index', ['event' => $this->event->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.edit');
    }
}
