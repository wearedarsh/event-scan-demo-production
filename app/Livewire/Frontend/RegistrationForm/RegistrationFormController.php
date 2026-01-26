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

    public $system_state = null;

    public $spaces_remaining;
    public $events;

    protected $listeners = [
        'update-step' => 'updateStep',
        'cancel-session' => 'cancelSessionAndRedirect',
        'finish-session' => 'finishSessionAndRedirect',
        'clear-session' => 'clearSession',
        'enter-system-state' =>'enterSystemState',
        'clear-system-state' =>'clearSystemState'
    ];

    public function enterSystemState(string $state){
        $this->system_state = $state;
    }

    public function clearSystemState(){
        $this->system_state = null;
    }

    public function getIsPenultimateStepProperty(){
        return $this->current_step === ($this->total_steps - 1);
    }
    
    public function cancelSessionAndRedirect(){
        if(session('registration_id') && $this->registration){
            $this->registration->update([
                'registration_status' => 'cancelled'
            ]);
        }
        $this->clearSession();
        return redirect()->route('home');
    }

    public function clearSession(){
        Session::forget('registration_id');
        Auth::logout();
    }

    public function finishSessionAndRedirect(){
        if(session('registration_id') && $this->registration){
            $this->registration->update([
                'registration_form_locked' => true
            ]);
        }
        $this->clearSession();
        return redirect()->route('home');
    }

    public function getSpacesLabelProperty(){
        return Str::plural('space', $this->spaces_remaining);
    }

    public function createNewRegistration(){
        $this->registration = Registration::create([
                'event_id' => $this->event->id
        ]);

        session(['registration_id' => $this->registration->id]);
    }

    public function mount(Event $event, $system_state = null)
    {
        $this->event = $event;

        if(!$this->event->is_registerable)
        {
            return redirect()->route('home');
        }

        $registration_id = session('registration_id');

        if($system_state){
            $this->dispatch('enter-system-state', $system_state);
        }

        if($registration_id){
            $registration = Registration::where(
                'id', $registration_id)
                ->where('event_id', $this->event->id)
                ->first();

            if(!$registration->registration_form_locked){
                $this->registration = $registration;
            }else{
                $this->createNewRegistration();
            }
        }else{
            $this->createNewRegistration();
        }

        $this->spaces_remaining = $this->event->space_remaining;
        $this->registration_form = $this->event->registrationForm;
        $this->total_steps = $this->registration_form->steps->count();
        $this->registration_type = $this->registration_form->type;


        if($this->registration->last_intended_step){
            $this->current_step = $this->registration->last_intended_step;
            $this->registration->update([
                'last_intended_step' => null
            ]);
        }

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
