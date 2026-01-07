<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Steps;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormStep;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public Event $event;
    public FeedbackForm $feedback_form;
    public string $title = '';
    public int $order = 0;

    public function mount(Event $event, FeedbackForm $feedback_form)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        FeedbackFormStep::create([
            'title' => $this->title,
            'display_order' => $this->order,
            'feedback_form_id' => $this->feedback_form->id,
        ]);

        session()->flash('success', 'Step created');
        return redirect()->route('admin.events.feedback-form.manage', [
            'event' => $this->event->id,
            'feedback_form' => $this->feedback_form->id,
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.steps.create');
    }
}
