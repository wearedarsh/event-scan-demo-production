<div>
    @include('livewire.frontend.registration-form.partials.nav')

    <main class="max-w-3xl mx-auto px-6 pt-16 space-y-6">
        <x-registration.event-info
            :event="$event"
            :spaces-remaining="$event->spaces_remaining"
        />

        @if($currentStep->type === 'dynamic')
            <livewire:frontend.registration-form.dynamic-step
                :step="$currentStep"
                :wire:key="'step-'.$currentStep->id"
            />
        @else
            @include("livewire.frontend.registration-form.steps.{$currentStep->key_name}")
        @endif

    </main>
</div>
