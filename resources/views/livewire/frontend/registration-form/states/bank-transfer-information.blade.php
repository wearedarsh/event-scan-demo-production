<div class="space-y-4">
    <x-registration.form-step>

        <div class="bg-[var(--color-bg)] rounded-lg p-4 text-[var(--color-secondary)]">
            {!! client_setting('payment.booking.bank_transfer.information.header_html') !!}
        </div>

        <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-5 rounded-lg text-sm text-[var(--color-secondary)] space-y-2">
            {!! client_setting('payment.booking.bank_transfer.information.details_intro_html') !!}
            <div class="mt-4 space-y-1 text-[var(--color-text)]">
                <p><strong>Amount:</strong> {{ $currency_symbol }}{{ $this->registration->calculated_total }}</p>
                {!! client_setting('payment.bank_transfer.information.bank_details_html') !!}
            </div>
        </div>

        <div class="bg-[var(--color-bg)] rounded-lg p-4 text-[var(--color-secondary)]">
            {!! client_setting('payment.booking.bank_transfer.information.details_footer_html') !!}
        </div>

        <x-registration.navigate-button
            wire:click="$dispatch('cancel-session')">
            {{ client_setting('payment.booking.bank_transfer.information.finish_button_label') }}
        </x-registration.navigate-button>

    </x-registration.form-step>

    <div class="grid grid-cols-4">
        <div class="col-span-2">
            <x-registration.navigate-button
                wire:click="$dispatch('clear-system-state')">
                Previous
            </x-registration.navigate-button>
        </div>
    </div>

</div>
