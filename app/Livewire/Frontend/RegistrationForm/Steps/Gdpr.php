<?php

namespace App\Livewire\Frontend\RegistrationForm\Steps;

use Livewire\Component;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class Gdpr extends Component
{
    public Event $event;
    public Registration $registration;
    public array $opt_in_responses = [];
    public bool $email_marketing_opt_in = false;

    public $step_help_info;
    public $total_steps;
    public $current_step;
    public bool $is_penultimate_step = false;

    protected $listeners = [
        'validate-step' => 'validateStep',
    ];

    public function mount()
    {
        $existing_responses = $this->registration->optInResponses
            ->pluck('value', 'event_opt_in_check_id')
            ->map(fn($val) => (bool) $val)
            ->toArray();

        foreach ($this->event->eventOptInChecks as $check) {
            $this->opt_in_responses[$check->id] = $existing_responses[$check->id] ?? false;
        }

        if (Auth::check()) {
            $this->email_marketing_opt_in = (bool) Auth::user()->email_marketing_opt_in;
        }
    }

    public function storeOptInResponses(): void
    {

        if (Auth::check()) {
            Auth::user()->update([
                'email_marketing_opt_in' => $this->email_marketing_opt_in,
            ]);
        }

        foreach ($this->opt_in_responses as $checkId => $value) {
            $this->registration->optInResponses()->updateOrCreate(
                ['event_opt_in_check_id' => $checkId],
                ['value' => (bool) $value]
            );
        }
    }

    public function validateStep(string $direction): void
    {
        $this->dispatch('scroll-to-top');
        $this->storeOptInResponses();
        $this->dispatch('update-step', $direction);
    }

    public function render()
    {
        return view('livewire.frontend.registration-form.steps.gdpr');
    }
}
