<div class="space-y-4">
    <x-registration.form-step>
        @if($step_help_info)
            <x-registration.form-info>
                {{ $step_help_info }}
            </x-registration.form-info>
        @endif
        @if($this->registration)
            <div class="space-y-2 text-sm text-[var(--color-text)]">
                <div class="bg-[var(--color-bg)] rounded-lg px-4 py-2">
                    {{ $this->registration->title }} {{ $this->registration->first_name }} {{ $this->registration->last_name }}
                </div>
                <div class="bg-[var(--color-bg)] rounded-lg px-4 py-2">
                    {{ $this->registration->email }}
                </div>
            </div>

            <div class="pt-6">
                {{ client_setting('booking.approval_complete.header_html')}}
            </div>


            <div class="flex justify-between bg-[var(--color-bg)] rounded-lg px-4 py-2 mt-2 font-semibold text-[var(--color-secondary)]">
                {{ client_setting('booking.approval_complete.content_html') }}
            </div>
        @endif

        
    </x-registration.form-step>

    <div class="grid grid-cols-4">
        <div class="col-span-2">
            <x-registration.navigate-button
                wire:click="$dispatch('validate-step', ['backward'])">
                Previous
            </x-registration.navigate-button>
        </div>
    </div>
    <div class="flex w-full flex-row gap-4 pt-6 justify-center">
        <x-registration.navigate-cancel-link wire:click="$dispatch('clear-session')">
            Cancel
        </x-registration.navigate-cancel-link>
    </div>

</div>
