<div class="space-y-4">

    <x-registration.step-indicator
        :current="1"
        :total="6"
        title="Personal details"
    />

    <x-registration.message type="error" />

    <x-registration.form-step>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-registration.input-select
                label="Title"
                wire:model="title"
                placeholder="Please select..."
            >
                <option value="Dr">Dr</option>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Miss">Miss</option>
                <option value="Ms">Ms</option>
                <option value="Professor">Professor</option>
            </x-registration.input-select>

            <x-registration.input-text
                label="First name"
                wire:model="first_name"
            />

            <x-registration.input-text
                label="Last name"
                wire:model="last_name"
            />

        </div>

        {{-- Address --}}
        <x-registration.input-text
            label="Address line 1"
            wire:model="address_line_one"
        />

        {{-- Town + Postcode --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <x-registration.input-text
                label="Town"
                wire:model="town"
            />

            <x-registration.input-text
                label="Postcode"
                wire:model="postcode"
            />

        </div>

        {{-- Country --}}
        <x-registration.input-select
            label="Country"
            wire:model="country_id"
            placeholder="Please select..."
        >
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </x-registration.input-select>

        {{-- Navigation --}}
        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1"></div>
            <div class="flex-1">
                <x-registration.navigate-button action="nextStep">
                    Next
                </x-registration.navigate-button>
            </div>
        </div>

        <x-registration.navigate-cancel-link action="clearLocalStorageAndRedirect" />

        {{-- Scroll handling --}}
        <div
            x-data
            x-on:stepChanged.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-on:scrollToTop.window="window.scrollTo({ top: 0, behavior: 'smooth' })"
        ></div>

    </x-registration.form-step>

</div>
