<?php

namespace App\Livewire\Frontend\RegistrationForm;

use Livewire\Component;
use App\Models\Event;
use App\Models\RegistrationForm;
use App\Models\RegistrationFormStep;
use App\Models\Registration;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

#[Layout('livewire.frontend.registration-form.layouts.app')]
class RegistrationFormController extends Component
{
    public RegistrationForm $registration_form;
    public RegistrationFormStep $registration_form_step;
    public ?Registration $registration = null;
    public Event $event;

    public string $registration_type;

    public int $total_steps;
    public string $step_type;
    public int $current_step = 1;
    public string $step_label;
    public string $step_key_name;
    public $step_help_information_copy = null;

    public $spaces_remaining;
    public $events;

    protected $listeners = [
        'update-step' => 'updateStep',
        'clear-session' => 'clearSessionAndRedirect'
    ];

    public function getIsPenultimateStepProperty(){
        return $this->current_step === ($this->total_steps - 1);
    }

    
    public function clearSessionAndRedirect(){
        
        if(session('registration_id') && $this->registration){
            $this->registration->update([
                'registration_status' => 'cancelled'
            ]);
        }

        Session::forget('registration_id');
        Auth::logout();
        return redirect()->route('home');
    }

    public function getSpacesLabelProperty(){
        return Str::plural('space', $this->spaces_remaining);
    }

    public function mount(Event $event)
    {
        $this->event = $event;
        $registration_id = session('registration_id');

        if($registration_id){
            $this->registration = Registration::where(
                'id', $registration_id)
                ->where('event_id', $this->event->id)
                ->first();
        }else{
            $this->registration = Registration::create([
                'event_id' => $this->event->id
            ]);

            session(['registration_id' => $this->registration->id]);
        }

        $this->spaces_remaining = $this->event->space_remaining;
        $this->registration_form = $this->event->registrationForm;
        $this->total_steps = $this->registration_form->steps->count();
        $this->registration_type = $this->registration_form->type;

        $this->registration_form_step = $this->registration_form->steps
        ->firstWhere('display_order', $this->current_step);

        $this->step_type = $this->registration_form_step->type;
        $this->step_label = $this->registration_form_step->label;
        $this->step_key_name = $this->registration_form_step->key_name;
        $this->step_help_information_copy = $this->registration_form_step->help_information_copy;

    }

    public function updateStep($direction)
    {
        if($direction === 'forward'){
            $this->current_step++;
            
        }else{
            $this->current_step--;
        }
        $this->updateCurrentStepProperties();
    }

    public function updateCurrentStepProperties(){
        $this->dispatch('scroll-to-top');

        $this->registration_form_step = $this->registration_form->steps
        ->firstWhere('display_order', $this->current_step);

        $this->step_type = $this->registration_form_step->type;
        $this->step_label = $this->registration_form_step->label;
        $this->step_key_name = $this->registration_form_step->key_name;
        $this->step_help_information_copy = $this->registration_form_step->help_information_copy;

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
