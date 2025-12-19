<div class="space-y-4">
    <x-registration.form-step>

        <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
            <div class="col-span-1">
                <x-registration.input-label for="mobile_country_code">Country code</x-registration.input-label>
                <x-registration.input-text
                    id="mobile_country_code"
                    wire:model="mobile_country_code"
                    placeholder="e.g. +44" />
            </div>
            <div class="col-span-2 md:col-span-3">
                <x-registration.input-label for="mobile_number">Mobile number</x-registration.input-label>
                <x-registration.input-text
                    id="mobile_number"
                    wire:model="mobile_number" />
            </div>
        </div>

        <x-registration.form-info>
            Your email and password will be required to access your account before, during, and after the event. Please make sure you note your account details.
        </x-registration.form-info>

        <div>
            <x-registration.input-label for="email">Email address</x-registration.input-label>
            <x-registration.input-text
                id="email"
                type="email"
                wire:model="email" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-registration.input-label for="password">Password</x-registration.input-label>
                <x-registration.input-text
                    id="password"
                    type="password"
                    wire:model="password" />
                    <x-registration.input-help>
                        Your password must be at least 8 characters long.
                    </x-registration.input-help>
            </div>
            <div>
                <x-registration.input-label for="password_confirmation">Password confirmation</x-registration.input-label>
                <x-registration.input-text
                    id="password_confirmation"
                    type="password"
                    wire:model="password_confirmation" />
                
            </div>
        </div>
    </x-registration.form-step>

</div>