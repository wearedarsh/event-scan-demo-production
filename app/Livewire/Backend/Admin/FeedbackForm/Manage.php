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

    /** @var array<int,int> */
    public array $stepOrders = [];

    /** @var array<int,int> */
    public array $groupOrders = [];


    public function mount(Event $event, FeedbackForm $feedback_form)
    {
        $this->event = $event;
        $this->feedback_form = $feedback_form;

        $this->loadOrders();
    }


    /**
     * Load all steps + groups into order arrays
     */
    protected function loadOrders(): void
    {
        $this->stepOrders = $this->feedback_form
            ->steps()
            ->orderBy('order')
            ->pluck('order', 'id')
            ->toArray();

        $this->groupOrders = $this->feedback_form
            ->groups()
            ->orderBy('order')
            ->pluck('order', 'id')
            ->toArray();
    }


    public function deleteGroup(int $id)
    {
        FeedbackFormGroup::findOrFail($id)->delete();

        session()->flash('success', 'Question group deleted.');
        $this->loadOrders();
    }


    public function deleteStep(int $id)
    {
        FeedbackFormStep::findOrFail($id)->delete();

        session()->flash('success', 'Step deleted.');
        $this->loadOrders();
    }


    /**
     * Delete question
     */
    public function deleteQuestion(int $id)
    {
        FeedbackFormQuestion::findOrFail($id)->delete();

        session()->flash('success', 'Question deleted.');
    }


    public function render()
    {
        return view('livewire.backend.admin.feedback-form.manage', [
            'steps' => $this->feedback_form->steps()->orderBy('order')->get(),
            'groups' => $this->feedback_form->groups()->orderBy('order')->get(),
        ]);
    }
}
