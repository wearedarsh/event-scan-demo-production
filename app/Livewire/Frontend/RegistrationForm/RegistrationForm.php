<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Layout;

#[Layout('livewire.frontend.registration-form.layouts.app')]
class RegistrationForm extends Component
{
    public Event $event;
    public int $step = 1;
    public array $stepState = [];
    public $page_title = 'Test page title';

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.parent', [
            'current_step_type' => 'rigid',
            'page_title' => $this->page_title
        ]);
    }
}
