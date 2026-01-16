<div class="space-y-4">
    <x-registration.form-step>
        @if($step_help_info)
            <x-registration.form-info>
                {{ $step_help_info }}
            </x-registration.form-info>
        @endif

        <div class="bg-[var(--color-bg)] rounded-lg p-4 text-[var(--color-secondary)]">
            <h3 class="text-lg font-semibold mb-1">Thank you for registering for this event</h3>
            <p class="text-sm text-[var(--color-text-light)]">
                Our team have been notified of your application.
            </p>
        </div>

        <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-5 rounded-lg text-sm text-[var(--color-secondary)] space-y-2">
            <p class="font-semibold">
                Please arrange payment with your bank using the details below.
            </p>
            <p class="text-[var(--color-text-light)]">
                We’ve also sent you an email with full details for your convenience.
            </p>

            <div class="mt-4 space-y-1 text-[var(--color-text)]">
                <p><strong>Amount:</strong> {{ $currency_symbol }}{{ $this->registration_total }}</p>
                {!! client_setting('payment.bank_transfer_detail_html') !!}
            </div>
        </div>

        <x-registration.form-info>
            If you do not receive an email, please check your spam or junk folder.
            We recommend adding <strong>{{ client_setting('email.customer.from_address') }}</strong> to your contacts to ensure future emails and updates are received.
            <br><br>
            Please note that your place will not be reserved until payment has been received and confirmed by our office.
        </x-registration.form-info>

    </x-registration.form-step>

</div>
