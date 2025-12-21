<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Layout('livewire.frontend.registration-form.layouts.app')]
class RegistrationFormController extends Component
{
    public RegistrationForm $registration_form;
    public RegistrationFormStep $registration_form_step;
    public Event $event;
    public int $total_steps;
    public string $step_type;
    public int $current_step = 1;
    public string $step_label;
    public string $step_key_name;
    public $spaces_remaining;
    public $events;

    protected $listeners = [
        'next-step' => 'nextStep',
        'prev-step' => 'prevStep',
    ];
    
    public function getSpacesLabelProperty(){
        return Str::plural('space', $this->spaces_remaining);
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->spaces_remaining = $this->event->space_remaining;
        $this->registration_form = $this->event->registrationForm;
        $this->total_steps = $this->registration_form->steps->count();

        $this->registration_form_step = $this->registration_form->steps
        ->firstWhere('display_order', $this->current_step);

        $this->step_type = $this->registration_form_step->type;
        $this->step_label = $this->registration_form_step->label;
        $this->step_key_name = $this->registration_form_step->key_name;

    }

    public function nextStep()
    {
        if($this->current_step < $this->total_steps){
            $this->current_step++;
            $this->updateCurrentStepProperties();
        }
    }

    public function prevStep()
    {
        if($this->current_step > 1){
            $this->current_step--;
            $this->updateCurrentStepProperties();
        }
    }

    public function updateCurrentStepProperties(){
        $this->dispatch('scroll-to-top');

        $this->registration_form_step = $this->registration_form->steps
        ->firstWhere('display_order', $this->current_step);

        $this->step_type = $this->registration_form_step->type;
        $this->step_label = $this->registration_form_step->label;
        $this->step_key_name = $this->registration_form_step->key_name;
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
