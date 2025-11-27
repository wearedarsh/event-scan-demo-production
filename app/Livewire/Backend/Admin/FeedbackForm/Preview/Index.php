<?php

namespace App\Livewire\Backend\Admin\FeedbackForm\Preview;

use Livewire\Component;
use App\Models\FeedbackForm;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public FeedbackForm $form;

    public int $current_step_index = 0;
    public array $steps = [];
    public array $answers = [];

    public function mount(FeedbackForm $feedback_form)
    {
        $this->form = $feedback_form;

        if ($this->form->multi_step) {
            $this->form->load([
                'steps' => fn ($q) => $q->orderBy('order'),
                'steps.groups' => fn ($q) => $q->orderBy('order'),
                'steps.groups.questions' => fn ($q) => $q->orderBy('order'),
            ]);
            $this->steps = $this->form->steps->values()->all();
        } else {
            $this->form->load([
                'groups' => fn ($q) => $q->orderBy('order'),
                'groups.questions' => fn ($q) => $q->orderBy('order'),
            ]);
        }
    }

    /** Normalise answer values (match customer component semantics) */
    protected function normalise($value): string
    {
        if (!is_string($value)) return (string)$value;
        // collapse whitespace + trim
        return trim(preg_replace('/\s+/u', ' ', $value));
    }

    protected function isVisible($question): bool
    {
        // No condition? Always visible
        if (!$question->visible_if_question_id || !$question->visible_if_answer) {
            return true;
        }

        $given = $this->normalise($this->answers[$question->visible_if_question_id] ?? '');
        $want  = $this->normalise($question->visible_if_answer);

        return $given === $want;
    }

    public function getRulesProperty()
    {
        return $this->rules();
    }

    public function rules(): array
    {
        $rules = [];

        $questionSet = $this->form->multi_step
            ? $this->form->steps[$this->current_step_index]->groups->flatMap->questions
            : $this->form->groups->flatMap->questions;

        foreach ($questionSet as $question) {
            if ($question->is_required && $this->isVisible($question)) {
                $rules["answers.{$question->id}"] = 'required';
            }
        }

        return $rules;
    }

    protected function messages(): array
    {
        return ['answers.*.required' => 'Please answer this question'];
    }

    /** In preview we don't persist; we still normalise for visibility/validation */
    public function updatedAnswers($value, $key): void
    {
        $this->answers[$key] = $this->normalise($value);
    }

    public function nextStep()
    {
        $rules = $this->rules();
        if (!empty($rules)) {
            $this->validate($rules);
        }

        if ($this->current_step_index < count($this->steps) - 1) {
            $this->current_step_index++;
        }
    }

    public function previousStep()
    {
        if ($this->current_step_index > 0) {
            $this->current_step_index--;
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.preview.index');
    }
}
