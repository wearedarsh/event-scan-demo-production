<div class="space-y-4">
    <x-registration.form-step>
        @if($step_help_info)
            <x-registration.form-info>
                {{ $step_help_info }}
            </x-registration.form-info>
        @endif

        @if($event->auto_email_opt_in)
            <x-registration.form-info>
                {{ $event->email_opt_in_description ?? 'By registering for this event, I agree that I will automatically be enrolled to receive all emails and correspondence relating to the event.' }}
            </x-registration.form-info>
        @endif

        @if($event->show_email_marketing_opt_in)
            <x-registration.input-checkbox
                id="email_marketing_opt_in"
                wire:model="email_marketing_opt_in"
                label="Please keep me informed of future {{ client_setting('general.customer_friendly_name') }} events."
            />
        @endif

        @if($event->eventOptInChecks)
            @foreach($event->eventOptInChecks as $check)
                <x-registration.input-checkbox
                    id="opt_in_{{ $check->id }}"
                    wire:model="opt_in_responses.{{ $check->id }}"
                    label="{{ $check->description }}"
                />
            @endforeach
        @endif

    </x-registration.form-step>

    <div class="flex gap-4 pt-6">
        <div class="flex-1">
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['backward'])">
                Previous
            </x-registration.navigate-button>
        </div>

        <div class="flex-1">
            <x-registration.navigate-button wire:click="$dispatch('validate-step', ['forward'])">
                @if($registration_form->type === 'approval' && $is_penultimate_step) 
                    {{ client_setting('booking.navigation.approval.final_step_button_label') }}
                @else 
                    Next 
                @endif
            </x-registration.navigate-button>
        </div>
    </div>

    <div class="flex w-full flex-row gap-4 pt-6 justify-center">
        <x-registration.navigate-cancel-link wire:click="$dispatch('cancel-session')">
            Cancel
        </x-registration.navigate-cancel-link>
    </div>

</div>
