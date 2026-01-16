<div>
    <div id="step-top"></div>
    <main class="max-w-3xl mx-auto px-6 pt-16 space-y-6">
        
        <x-registration.event-info
            :event="$event"
            :spaces_remaining="$spaces_remaining"
        />
        <x-registration.step-indicator
            :label="$step_label"
            :current="$current_step"
            :total="$total_steps"
        />
        @if($this->isPenultimateStep)
            True
        @else
            False
        @endif

        @if($step_type === 'rigid')
            <livewire:is :component="'frontend.registration-form.steps.'. $step_key_name" :key="$step_key_name" :event="$event" :current_step="$current_step" :total_steps="$total_steps" :registration="$registration" :step_help_info="$step_help_information_copy" :is_penultimate_step="$this->isPenultimateStep" />
        @else
            <livewire:is component="frontend.registration-form.steps.dynamic" :key="$step_key_name" :event="$event" :registration_form_step="$registration_form_step" :total_steps="$total_steps" :current_step="$current_step" :step_help_info="$step_help_information_copy" :registration="$registration" :is_penultimate_step="$this->isPenultimateStep" />
        @endif
    
    </main>
    <x-registration.scroll-to-top target="step-top" />
    
</div>