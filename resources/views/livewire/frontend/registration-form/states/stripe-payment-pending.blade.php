<div class="space-y-4">
    <x-registration.form-step>
            
        {!! client_setting('payment.booking.stripe.payment.pending.header_html') !!}

        <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-5 rounded-lg text-sm text-[var(--color-secondary)] space-y-2">
            
            {!! client_setting('payment.booking.stripe.payment.pending.details_html') !!}

            <div class="mt-4 space-y-1 text-[var(--color-text)]">
                <p><strong>Booking reference:</strong> {{ $this->registration->booking_reference }}</p>
                <p><strong>Amount:</strong> {{ $currency_symbol }}{{ $this->registration->calculated_total }}</p>
            </div>
        </div>
    

        <x-registration.navigate-button
            wire:click="$dispatch('finish-session')">
            {{ client_setting('payment.booking.stripe.payment.pending.finish_button_label') }}
        </x-registration.navigate-button>

    </x-registration.form-step>

</div>
