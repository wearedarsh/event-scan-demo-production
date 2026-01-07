<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Steps;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormStep;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public Event $event;
    public FeedbackForm $feedback_form;
    public FeedbackFormStep $step;
    public string $title;
    public int $order;

    public function mount(Event $event, FeedbackForm $feedback_form, FeedbackFormStep $step)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;
        $this->step = $step;

        $this->title = $step->title;
        $this->order = $step->display_order;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'display_order' => 'required|integer|min:0',
        ]);

        $this->step->update([
            'title' => $this->title,
            'display_order' => $this->order,
        ]);

        session()->flash('success', 'Step updated');
        return redirect()->route('admin.events.feedback-form.manage', [
            'event' => $this->event->id,
            'feedback_form' => $this->feedback_form->id,
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.steps.edit');
    }
}
