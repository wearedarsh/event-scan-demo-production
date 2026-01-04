<div class="space-y-4">
    <x-registration.form-step>

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
                <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Your ticket selections</h3>
            </div>

            @foreach ($this->registration->registrationTickets as $ticket)
                <div class="flex justify-between bg-[var(--color-bg)] rounded-lg px-4 py-2 text-sm text-[var(--color-text)]">
                    <span>{{ $ticket->quantity }} × {{ $ticket->ticket->name }}</span>
                    <span>{{ $currency_symbol }}{{ $ticket->line_total }}</span>
                </div>
            @endforeach


            <div class="flex justify-between bg-[var(--color-bg)] rounded-lg px-4 py-2 mt-2 font-semibold text-[var(--color-secondary)]">
                <span>Booking total</span>
                <span>{{ $this->currency_symbol }}{{ $registration_total }}</span>
            </div>
        @endif

        <!-- Payment methods -->
        @if($registration_total > 0)
            <div class="pt-6">
                <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Select a payment method</h3>
            </div>

            @if($this->event->eventPaymentMethods)
                @if($this->event->eventPaymentMethods->contains('payment_method','bank_transfer'))
                    <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
                        <strong>Bank Transfer</strong><br>
                        <x-registration.form-info>
                            If you select bank transfer, your place will not be reserved until payment is confirmed.
                        </x-registration.form-info>
                        <x-registration.navigate-button wire:click="bankTransferPayment">
                            Pay by bank transfer
                        </x-registration.navigate-button>
                    </div>
                @endif

                @if($this->event->eventPaymentMethods->contains('payment_method','stripe') && $this->registration->country->stripe_enabled)
                    <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
                        <strong>Secure card payment</strong><br>
                        <img src="{{ asset('images/frontend/stripe.png') }}" alt="Stripe Secure Payments" class="mt-2 h-8 inline-block opacity-80">
                        <p>Payment will be processed securely via Stripe.</p>

                        <div class="flex justify-end mt-3">
                            <x-registration.navigate-button wire:click="stripePayment">
                                Pay by card
                            </x-registration.navigate-button>
                        </div>
                    </div>
                @endif
            @endif

        @else
            <x-registration.form-info>
                <strong>No payment is due</strong><br>
                Please click below to confirm your registration and secure your place at this event.
            </x-registration.form-info>

            <x-registration.navigate-button wire:click="$dispatch('noPaymentDue')">
                Complete booking
            </x-registration.navigate-button>
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

</div>
