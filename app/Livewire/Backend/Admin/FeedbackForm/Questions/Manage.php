<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Questions;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormQuestion;
use App\Models\FeedbackForm;

#[Layout('livewire.backend.admin.layouts.app')]
class Manage extends Component
{
    public Event $event;
    public FeedbackForm $feedback_form;
    public FeedbackFormGroup $group;

    public function mount(Event $event, FeedbackForm $feedback_form, FeedbackFormGroup $group)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;
        $this->group = $group;
    }

    public function deleteQuestion(int $id)
    {
        $question = FeedbackFormQuestion::findOrFail($id);
        $message = 'Question has been deleted.';

        $child_questions = FeedbackFormQuestion::where('visible_if_question_id', $question->id)->get();

        foreach ($child_questions as $child) {
            $child->delete();
            $message .= ' A conditional question was also deleted.';
        }

        $question->delete();

        session()->flash('success', $message);
        return redirect()->route('admin.events.feedback-form.questions.manage', [
            'event' => $this->event->id,
            'feedback_form' => $this->feedback_form->id,
            'group' => $this->group,
        ]);
    }





    public function render()
    {
        return view('livewire.backend.admin.feedback-form.questions.manage');
    }
}
