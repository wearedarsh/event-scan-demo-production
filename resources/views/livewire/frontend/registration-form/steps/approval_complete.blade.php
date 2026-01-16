<div class="space-y-4">
    <x-registration.form-step>
        @if($step_help_info)
            <x-registration.form-info>
                {{ $step_help_info }}
            </x-registration.form-info>
        @endif
        @if($this->registration)
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
