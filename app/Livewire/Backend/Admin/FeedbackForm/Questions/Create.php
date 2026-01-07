<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Questions;

use App\Models\Event;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormGroup;
use App\Models\FeedbackFormQuestion;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Create extends Component
{
    public FeedbackForm $feedback_form;
    public Event $event;
    public FeedbackFormgroup $group;

    public string $question_text = '';
    public int $order = 0;
    public ?int $feedback_form_group_id = null;
    public ?string $type = null;
    public ?string $options_text = null;

    public $is_optional;
    public ?int $visible_if_question_id = null;
    public ?string $visible_if_answer = null;

    public $groups;
    public $conditional_questions;

    public function mount(Event $event, FeedbackForm $feedback_form, FeedbackFormGroup $group)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;
        $this->group = $group;
        $this->conditional_questions = FeedbackFormQuestion::where('feedback_form_group_id', $this->group->id)
            ->whereIn('type', ['radio', 'multi-select'])
            ->get();
    }

    public function store()
    {
        $this->validate([
            'question_text' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'type' => 'required|in:radio,multi-select,text,textarea',
        ]);

        if (in_array($this->type, ['radio', 'multi-select'])) {
            $this->validate([
                'options_text' => 'required|string|max:1000',
            ]);
        }

        if ($this->is_optional) {
            $this->validate([
                'visible_if_question_id' => 'required|exists:feedback_form_questions,id',
                'visible_if_answer' => 'required|string|max:255',
            ]);
        }

        FeedbackFormQuestion::create([
            'feedback_form_id' => $this->feedback_form->id,
            'question' => $this->question_text,
            'display_order' => $this->order,
            'type' => $this->type,
            'feedback_form_group_id' => $this->group->id,
            'is_required' => true,
            'options_text' => $this->options_text,
            'visible_if_question_id' => $this->is_optional ? $this->visible_if_question_id : null,
            'visible_if_answer' => $this->is_optional ? $this->visible_if_answer : null,
        ]);

        session()->flash('success', 'Question created');
        return redirect()->route('admin.events.feedback-form.manage', [$this->event->id, $this->feedback_form->id]);
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.questions.create');
    }
}
