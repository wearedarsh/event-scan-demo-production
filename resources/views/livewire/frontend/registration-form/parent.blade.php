<div>
    @include('livewire.frontend.registration-form.partials.nav')

    <main class="max-w-3xl mx-auto px-6 pt-16 space-y-6">

        <x-registration.event-info
            :event="$event"
            :spaces-remaining="$event->spaces_remaining"
        />

        <x-registration.step-indicator
            current="1"
            total="15"
            label="Personal details"
        />

        <x-registration.message type="error" />

        @if($current_step_type === 'dynamic')
            Load dynamic here
        @else
            Load rigid here
        @endif

        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <x-registration.navigate-button
                    action="prevStep">
                    Previous
                </x-registration.navigate-button>
            </div>
            <div class="flex-1">
                <x-registration.navigate-button action="nextStep">
                    Next
                </x-registration.navigate-button>
            </div>
        </div>

        <x-registration.navigate-cancel-link action="" />

    </main>
</div>
