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

        <p>I am the parent blade</p> 

    </main>
</div>