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

        @if($step_type === 'rigid')
            <livewire:is :component="'frontend.registration-form.steps.'. $step_key_name" :key="$step_key_name" :event="$event" :current_step="$current_step" :registration="$registration" :step_help_info="$step_help_information_copy" />
        @else
            <livewire:is component="frontend.registration-form.steps.dynamic" :key="$step_key_name" :event="$event" :registration_form_step="$registration_form_step" :current_step="$current_step" :step_help_info="$step_help_information_copy" :registration="$registration" />
        @endif

    <x-registration.navigate-cancel-link action="clearLocalStorageAndRedirect" />
    
    </main>
    <x-registration.scroll-to-top target="step-top" />
    
</div>