<div class="space-y-4">

    <x-registration.form-step>

        @if($event->auto_email_opt_in)
            <x-registration.form-info>
                {{ $event->email_opt_in_description ?? 'By registering for this event, I agree that I will automatically be enrolled to receive all emails and correspondence relating to the event.' }}
            </x-registration.form-info>
        @endif

        @if($event->show_email_marketing_opt_in)
            <x-registration.input-checkbox
                id="email_marketing_opt_in"
                wire:model="email_marketing_opt_in"
                label="Please keep me informed of future {{ config('customer.contact_details.booking_website_company_name') }} events."
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

</div>
