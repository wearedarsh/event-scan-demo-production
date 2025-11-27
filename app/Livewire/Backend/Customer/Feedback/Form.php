<?php

namespace App\Livewire\Backend\Customer\Feedback;

use Livewire\Component;
use App\Models\FeedbackForm;
use App\Models\FeedbackFormSubmission;
use App\Models\FeedbackFormResponse;
use Livewire\Attributes\Layout;
use App\Services\EmailService;
use App\Mail\CertificateOfAttendanceConfirmationCustomer;
use Illuminate\Support\Facades\Auth;

#[Layout('livewire.backend.customer.layouts.app')]
class Form extends Component
{
    public FeedbackForm $form;
    public FeedbackFormSubmission $feedback_form_submission;

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

        $this->feedback_form_submission = FeedbackFormSubmission::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'feedback_form_id' => $this->form->id,
            ],
            [
                'status' => 'started',
            ]
        );

        $this->answers = $this->feedback_form_submission
            ->responses()
            ->pluck('answer', 'feedback_form_question_id')
            ->toArray();
    }

    protected function isVisible($question): bool
    {
        if (!$question->visible_if_question_id || !$question->visible_if_answer) {
            return true;
        }

        return trim($this->answers[$question->visible_if_question_id] ?? null) === $question->visible_if_answer;
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

    public function updatedAnswers($value, $key)
    {
        $question_id = $key;

        $questionSet = $this->form->multi_step
            ? $this->form->steps[$this->current_step_index]->groups->flatMap->questions
            : $this->form->groups->flatMap->questions;

        $question = $questionSet->firstWhere('id', $question_id);

        if (!$question || !$this->isVisible($question) || !$this->feedback_form_submission?->id) {
            return;
        }

        $this->feedback_form_submission->update(['status' => 'in_progress']);

        FeedbackFormResponse::updateOrCreate(
            [
                'feedback_form_submission_id' => $this->feedback_form_submission->id,
                'feedback_form_question_id' => $question_id,
            ],
            [
                'feedback_form_id' => $this->form->id,
                'answer' => $value,
            ]
        );
    }

    public function submit()
    {
        $rules = $this->rules();
        if (!empty($rules)) {
            $this->validate($rules);
        }

        $this->feedback_form_submission->update([
            'status' => 'complete',
            'submitted_at' => now(),
        ]);

        $mailable = new CertificateOfAttendanceConfirmationCustomer($this->feedback_form_submission->user, $this->form);

        EmailService::queueMailable(
            mailable: $mailable,
            recipient_email: $this->feedback_form_submission->user->email,
            recipient_user: $this->feedback_form_submission->user,
            friendly_name: 'Certificate of attendance confirmation',
            sender_id: null,
            type: 'System triggered',
            event_id: $this->feedback_form_submission->feedbackForm->event->id,
        );

        session()->flash('success', 'Thank you for completing the feedback form. Your Certificate of attendance is available below, an email has also been sent to your account email address for your convenience.');
        return redirect()->route('customer.bookings.index', ['user' => Auth::id()]);
    }

    public function nextStep()
    {
        $rules = $this->rules();
        if (!empty($rules)) {
            $this->validate($rules);
        }

        if ($this->current_step_index < count($this->steps) - 1) {
            $this->current_step_index++;
        } else {
            $this->submit();
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
        return view('livewire.backend.customer.feedback.form');
    }
}
