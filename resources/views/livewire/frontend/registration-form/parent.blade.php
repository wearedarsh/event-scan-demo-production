<div>
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
            <livewire:is :component="'frontend.registration-form.steps.'. $step_key_name" :key="$step_key_name" />
        @else
            <livewire:is component="frontend.registration-form.steps.dynamic" key="dynamic_step" />
        @endif

    </main>
</div>