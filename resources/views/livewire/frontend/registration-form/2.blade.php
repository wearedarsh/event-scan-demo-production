<div class="space-y-4">

    <x-registration.step-indicator
        :current="2"
        :total="6"
        label="Professional details"
    />

    <x-registration.message type="error" />

    <x-registration.form-step>
        <x-registration.input-label for="attendee_type_id">
            Currently held position
        </x-registration.input-label>
        <x-registration.input-text
            id="currently_held_position"
            label="Company"
            wire:model="currently_held_position"
        />

        <div>
            <x-registration.input-label for="attendee_type_id">
                Profession
                <br>
                <span class="text-xs font-normal text-[var(--color-text-light)]">
                    Please select from the list below
                </span>
            </x-registration.input-label>
            <x-registration.input-select
                id="attendee_type_id"
                wire:model="attendee_type_id"
                placeholder="Please select..."
            >
                @foreach($attendee_types as $attendee_type)
                    <option value="{{ $attendee_type->id }}">{{ $attendee_type->name }}</option>
                @endforeach
            </x-registration.input-select>
        </div>

        <x-registration.input-label for="attendee_type_id">
            Currently held position
        </x-registration.input-label>
        <x-registration.input-text
            id="attendee_type_other"
            label="Other
                <br><span class='text-xs font-normal text-[var(--color-text-light)]'>If your profession isn’t listed please enter it here</span>"
            wire:model="attendee_type_other"
        />

        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1">
                <x-registration.navigate-button action="prevStep" style="outline">
                    Previous
                </x-registration.navigate-button>
            </div>
            <div class="flex-1">
                <x-registration.navigate-button action="nextStep">
                    Next
                </x-registration.navigate-button>
            </div>
        </div>

        <x-registration.navigate-cancel-link action="clearLocalStorageAndRedirect" />

        <div
            x-data
            x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
        ></div>

    </x-registration.form-step>

</div>
