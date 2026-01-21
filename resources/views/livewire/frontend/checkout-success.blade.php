<div class="min-h-screen flex flex-col bg-[var(--color-bg)]">
  @include('livewire.frontend.partials.nav')
  <!-- ===== Hero ===== -->
<section class="relative flex items-center justify-center pt-40 pb-16 text-center overflow-hidden">
  <!-- Background -->
  <div class="absolute inset-0 bg-cover bg-center" 
       style="background-image:url('{{ asset('images/frontend/header-bg.jpg') }}');">
  </div>

  <!-- Content -->
  <div class="relative max-w-3xl mx-auto px-6 text-white z-10">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $event->title }}</h1>
  </div>
</section>
  <!-- Hero Header -->
  <header class="bg-[var(--color-secondary)] text-[var(--color-surface)] py-10 text-center relative">

    <div class="mt-6">
      <h1 class="text-3xl font-bold tracking-tight">Thank you for your booking</h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-1 flex flex-col items-center justify-center px-6 py-16">

    <!-- Success Container -->
    <div class="bg-[var(--color-surface)] border border-[var(--color-border)] shadow-sm rounded-2xl p-10 max-w-lg w-full text-center space-y-6">

      <div class="flex justify-center">
        <x-heroicon-o-check-circle class="w-16 h-16 text-[var(--color-accent)]" />
      </div>

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
        class="w-full bg-[var(--color-primary)] text-[var(--color-surface)] font-semibold px-6 py-3 rounded-lg transition hover:opacity-90">
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