<!-- Step 6: Payment -->
<div class="space-y-4">

  <!-- Step Indicator -->
  <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
    <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
      6 of 6
    </span>
    <span class="font-semibold text-[var(--color-secondary)]">Payment</span>
  </div>

  <!-- Error Message -->
  @if($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
      <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
    </div>
  @endif

  <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

    <!-- Personal details -->
    <div>
      <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Your personal details</h3>
    </div>

    @if($this->registration)
      <div class="space-y-2 text-sm text-[var(--color-text)]">
        <div class="bg-[var(--color-bg)] rounded-lg px-4 py-2">
          {{ $this->registration->title }} {{ $this->registration->first_name }} {{ $this->registration->last_name }}
        </div>
        <div class="bg-[var(--color-bg)] rounded-lg px-4 py-2">
          {{ $this->registration->user->email }}
        </div>
      </div>

      <!-- Ticket summary -->
      <div class="pt-6">
        <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Your ticket selections</h3>
      </div>

      @foreach($this->registration->registrationTickets as $ticket)
        <div class="flex justify-between bg-[var(--color-bg)] rounded-lg px-4 py-2 text-sm text-[var(--color-text)]">
          <span>{{ $ticket->quantity }} × {{ $ticket->ticket->name }}</span>
          <span>{{ $currency_symbol }}{{ number_format($ticket->quantity * $ticket->price_at_purchase) }}</span>
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
        <!-- Bank Transfer -->
        @if($this->event->eventPaymentMethods->contains('payment_method','bank_transfer'))
          <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
            <strong>Bank Transfer</strong><br>
            <p class="text-[var(--color-text-light)] mt-1">
              If you select bank transfer, please note that your place will not be reserved until payment has been received and confirmed by our office.
            </p>
            <button
              type="button"
              wire:click="bankTransferPayment"
              class="mt-3 bg-transparent border border-[var(--color-accent)] text-[var(--color-accent)] font-semibold px-4 py-2 rounded-lg hover:bg-[var(--color-accent)] hover:text-[var(--color-surface)] transition w-full sm:w-auto"
            >
              Pay by bank transfer
            </button>
          </div>
        @endif

        <!-- Stripe -->
        @if($this->event->eventPaymentMethods->contains('payment_method','stripe'))
          @if($this->registration->country->stripe_enabled)
            <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)]">
                <strong>Secure card payment</strong><br>
                <img src="{{ asset('images/frontend/stripe.png') }}" alt="Stripe Secure Payments" class="mt-2 h-8 inline-block opacity-80">

                <p class="text-[var(--color-text-light)] mt-1">
                    If you select credit/debit card, you will be taken to <strong>Stripe</strong> where payment will be processed securely.
                </p>

                <div class="flex justify-end mt-3">
                    <button
                    type="button"
                    wire:click="stripePayment"
                    class="bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-5 py-2 rounded-lg hover:opacity-90 transition"
                    >
                    Pay by card
                    </button>
                </div>
                </div>
          @endif
        @endif
      @endif

    <!-- No payment required -->
    @else
      <div>
        <h3 class="text-lg font-semibold text-[var(--color-secondary)]">Please confirm your booking</h3>
        <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-4 rounded-lg text-sm text-[var(--color-secondary)] mt-3">
          <strong>No payment is due</strong>
          <p class="mt-2 text-[var(--color-text-light)]">
            Please click below to confirm your registration and secure your place at this event.
          </p>
          <button
            type="button"
            wire:click="noPaymentDue"
            class="mt-3 bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-4 py-2 rounded-lg hover:opacity-90 transition w-full sm:w-auto"
          >
            Complete booking
          </button>
        </div>
      </div>
    @endif

    <!-- Navigation -->
    <div class="flex flex-row gap-4 pt-6">
      <div class="flex-1">
        <button
          type="button"
          wire:click="prevStep"
          class="w-full border border-[var(--color-primary)] text-[var(--color-primary)] font-semibold px-6 py-3 rounded-lg transition hover:bg-[var(--color-primary)] hover:text-[var(--color-surface)]"
        >
          Previous
        </button>
      </div>
    </div>

  </form>
</div>
