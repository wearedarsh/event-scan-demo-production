<?php
namespace App\Livewire\Backend\Admin\FeedbackForm;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('livewire.backend.admin.layouts.app')]
class Index extends Component
{
    public Event $event;
    public $feedback_forms;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->feedback_forms = $this->event->feedbackFormsAll()->get();
    }

    public function render()
    {
        return view('livewire.backend.admin.feedback-form.index');
    }
}
