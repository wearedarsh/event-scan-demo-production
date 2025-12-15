<div class="space-y-4">

    <x-registration.step-indicator
        :current="1"
        :total="6"
        label="Personal details"
    />

    <x-registration.message type="error" />

    <x-registration.form-step>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <x-registration.input-label for="title">Title</x-registration.input-label>
                <x-registration.input-select
                    id="title"
                    wire:model="title"
                    placeholder="Please select..."
                    :options="[
                        'Dr' => 'Dr',
                        'Mr' => 'Mr',
                        'Mrs' => 'Mrs',
                        'Miss' => 'Miss',
                        'Ms' => 'Ms',
                        'Professor' => 'Professor'
                    ]"
                />
            </div>

            <div>
                <x-registration.input-label for="first_name">First name</x-registration.input-label>
                <x-registration.input-text
                    id="first_name"
                    wire:model="first_name"
                />
            </div>

            <div>
                <x-registration.input-label for="last_name">Last name</x-registration.input-label>
                <x-registration.input-text
                    id="last_name"
                    wire:model="last_name"
                />
            </div>

        </div>

        <div>
            <x-registration.input-label for="address_line_one">Address line 1</x-registration.input-label>
            <x-registration.input-text
                id="address_line_one"
                wire:model="address_line_one"
            />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <x-registration.input-label for="town">Town</x-registration.input-label>
                <x-registration.input-text
                    id="town"
                    wire:model="town"
                />
            </div>

            <div>
                <x-registration.input-label for="postcode">Postcode</x-registration.input-label>
                <x-registration.input-text
                    id="postcode"
                    wire:model="postcode"
                />
            </div>

        </div>

        <div>
            <x-registration.input-label for="country_id">Country</x-registration.input-label>
            <x-registration.input-select
                id="country_id"
                wire:model="country_id"
                placeholder="Please select..."
                :options="$countries->pluck('name','id')->toArray()"
            />
        </div>

        <div class="flex flex-row gap-4 pt-6">
            <div class="flex-1"></div>
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
