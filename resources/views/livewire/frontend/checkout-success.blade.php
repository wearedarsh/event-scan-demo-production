<div class="min-h-screen flex flex-col bg-[var(--color-bg)]">

  <!-- Hero Header -->
  <header class="bg-[var(--color-secondary)] text-[var(--color-surface)] py-10 text-center relative">
    @include('livewire.frontend.partials.nav')
    <div class="mt-6">
      <h1 class="text-3xl font-bold tracking-tight">{{ $event->title }}</h1>
      <p class="text-[var(--color-text-light)] mt-2">
        {{ $event->formatted_start_date }} - {{ $event->formatted_end_date }}
      </p>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 flex flex-col items-center justify-center px-6 py-16">

    <!-- Success Container -->
    <div class="bg-[var(--color-surface)] border border-[var(--color-border)] shadow-sm rounded-2xl p-10 max-w-lg w-full text-center space-y-6">

      <!-- Checkmark Icon -->
      <div class="flex justify-center">
        <x-heroicon-o-check-circle class="w-16 h-16 text-[var(--color-accent)]" />
      </div>

      <!-- Title -->
      <h2 class="text-2xl font-bold text-[var(--color-secondary)]">Registration complete</h2>
      <p class="text-[var(--color-text-light)]">
        Thank you for your registration.
      </p>

      <!-- Dynamic Message -->
      @if($registration->registration_total > 0)
        <p class="text-[var(--color-text)]">
          Your payment was successful, and your booking is now confirmed.
        </p>
      @else
        <p class="text-[var(--color-text)]">
          Your booking is now confirmed.
        </p>
      @endif

      <!-- Divider -->
      <div class="border-t border-[var(--color-border)] my-4"></div>

      <!-- CTA Button -->
      <button
        type="button"
        wire:click="clearLocalStorageAndRedirect"
        class="w-full bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90"
      >
        Finish and Return to Homepage
      </button>

    </div>
  </main>

</div>

<script>
  Livewire.on('removeFromLocalStorageAndRedirect', () => {
    localStorage.removeItem('registration_id');
    localStorage.removeItem('user_id');
    window.location.href = "{{ route('home') }}";
  });
</script>
