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


            <div class="pt-3">
                {!! client_setting('booking.approval_complete.content_html') !!}
            </div>

            <div>
                <x-registration.navigate-button
                    wire:click="$dispatch('clear-session')">
                    {{ client_setting('booking.navigation.approval.finish_button_label') }}
                </x-registration.navigate-button>
            </div>
        @endif

        
    </x-registration.form-step>

</div>
