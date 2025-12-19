<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationForm;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Layout('livewire.frontend.registration-form.layouts.app')]
class RegistrationFormController extends Component
{
    public RegistrationForm $registration_form;
    public Event $event;
    public int $total_steps;
    public string $step_type = 'dynamic';
    public int $current_step = 1;
    public string $step_label = '';
    public string $step_key_name = 'account';
    public ?int $spaces_remaining = 2;
    public $events;
    
    public function getSpacesLabelProperty(){
        return Str::plural('space', $this->spaces_remaining);
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->registration_form = $this->event->registrationForm;
        $this->total_steps = $this->registration_form->steps->count();
    }

    public function nextStep()
    {

    }

    public function prevStep()
    {

    }


    public function render()
    {
        return view('livewire.frontend.registration-form.parent')
            ->layoutData([
                'title' => $this->event->title, 
                'event' => $this->event
            ]);
            
    }
}
