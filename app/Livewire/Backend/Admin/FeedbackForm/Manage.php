<?php

namespace App\Livewire\Backend\Admin\FeedbackForm;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormStep;
use App\Models\FeedbackFormQuestion;
use App\Models\FeedbackForm;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public Event $event;
    public FeedbackForm $feedback_form;

    public function mount(Event $event, FeedbackForm $feedback_form)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;
    }

    public function deleteGroup(int $id){ 
        FeedbackFormGroup::findOrFail($id)->delete();
        session()->flash('success', 'Question group has been deleted');
        return redirect()->route('admin.events.feedback-form.manage', ['event' => $this->event->id, 'feedback_form' => $this->feedback_form->id]);
    }

    public function deleteQuestion(int $id){
        FeedbackFormQuestion::findOrFail($id)->delete();
        session()->flash('success', 'Question has been deleted');
        return redirect()->route('admin.events.feedback-form.manage', ['event' => $this->event->id, 'feedback_form' => $this->feedback_form->id]);
    }

    public function deleteStep(int $id){
        FeedbackFormStep::findOrFail($id)->delete();
        session()->flash('success', 'Step has been deleted');
        return redirect()->route('admin.events.feedback-form.manage', ['event' => $this->event->id, 'feedback_form' => $this->feedback_form->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.manage');
    }
}
