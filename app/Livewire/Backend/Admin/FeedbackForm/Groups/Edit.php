<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Groups;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormStep;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Edit extends Component
{
    public FeedbackFormGroup $group;
    public FeedbackForm $feedback_form;
    public Event $event;
    public string $title;
    public int $order;
    public int $feedback_form_step_id;

    public function mount(Event $event, FeedbackFormGroup $group, FeedbackForm $feedback_form)
    {
        $this->event = $event;
        $this->group = $group;
        $this->feedback_form = $feedback_form;

        $this->title = $group->title;
        $this->order = $group->order;
        $this->feedback_form_step_id = $group->feedback_form_step_id;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'feedback_form_step_id' => 'required|exists:feedback_form_steps,id',
        ]);

        $this->group->update([
            'title' => $this->title,
            'order' => $this->order,
            'feedback_form_step_id' => $this->feedback_form_step_id,
        ]);

        session()->flash('success', 'Group updated');
        return redirect()->route('admin.events.feedback-form.manage', [
            'event' => $this->event->id,
            'feedback_form' => $this->feedback_form->id,
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.groups.edit', [
            'steps' => $this->feedback_form->steps()->orderBy('order')->get(),
        ]);
    }
}
