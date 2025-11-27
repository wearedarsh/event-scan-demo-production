<!-- Step 7: Bank Transfer -->
<div class="space-y-6">

  <!-- Step Header -->
  <div class="bg-[var(--color-surface)] py-3 px-6 mt-6 rounded-lg shadow-sm flex items-center gap-4">
    <span class="bg-[var(--color-accent-light)] text-[var(--color-text)] text-xs px-3 py-1 rounded-full font-semibold">
      Payment
    </span>
    <span class="font-semibold text-[var(--color-secondary)]">Bank Transfer</span>
  </div>

  <!-- Error Message -->
  @if($errors->any())
  <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
    <p class="text-yellow-700 text-sm">{{ $errors->first() }}</p>
  </div>
  @endif

  <!-- Confirmation + Bank Info -->
  <form class="text-left bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-6 space-y-6">

    <!-- Thank you note -->
    <div class="bg-[var(--color-bg)] rounded-lg p-4 text-[var(--color-secondary)]">
      <h3 class="text-lg font-semibold mb-1">Thank you for registering for this event</h3>
      <p class="text-sm text-[var(--color-text-light)]">
        The {{config('customer.contact_details.booking_website_company_name')}} team has been notified of your application.
      </p>
    </div>

    <!-- Bank transfer instructions -->
    <div class="bg-[var(--color-accent-light)] border-l-4 border-[var(--color-accent)] p-5 rounded-lg text-sm text-[var(--color-secondary)] space-y-2">
      <p class="font-semibold">
        Please arrange payment with your bank using the details below.
      </p>
      <p class="text-[var(--color-text-light)]">
        We’ve also sent you an email with full details for your convenience.
      </p>

      <div class="mt-4 space-y-1 text-[var(--color-text)]">
        <p><strong>Amount:</strong> {{ $currency_symbol }}{{ $this->registration_total }}</p>
        <p><strong>Bank:</strong> Medical Foundry Finance Trust</p>
        <p><strong>Address:</strong> 84 Kingsward House, Newbury Lane, London, EC2V 4MN</p>
        <p><strong>Account Name:</strong> Medical Foundry Ltd</p>
        <p><strong>Account No:</strong> 20483715</p>
        <p><strong>Sort Code:</strong> 52-41-73</p>
        <p><strong>IBAN:</strong> GB21 MDFT 5241 7320 4837 15</p>
        <p><strong>SWIFT/BIC:</strong> MDFTGB2L</p>
      </div>
    </div>

    <!-- Email reminder -->
    <div class="text-sm text-[var(--color-text-light)] leading-snug">
      If you do not receive an email, please check your spam or junk folder.
      We recommend adding <strong>{{config('mail.customer.address')}}</strong> to your contacts to ensure future emails and updates are received.
      <br><br>
      Please note that your place will not be reserved until payment has been received and confirmed by our office.
    </div>

    <!-- Navigation Buttons -->
    <div class="flex flex-row gap-4 pt-6">
      <div class="flex-1">
        <button
          type="button"
          wire:click="prevStep"
          class="w-full border border-[var(--color-primary)] text-[var(--color-primary)] font-semibold px-6 py-3 rounded-lg transition hover:bg-[var(--color-primary)] hover:text-[var(--color-surface)]">
          Previous
        </button>
      </div>
      <div class="flex-1 flex justify-end">
        <button
          type="button"
          wire:click="clearLocalStorageAndRedirect"
          class="bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90">
          Finish & Return to Homepage
        </button>
      </div>
    </div>

  </form>
</div>