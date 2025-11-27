@extends('livewire.frontend.layouts.app')

@section('content')

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
    <p class="text-lg text-white/90 mb-10">
      {{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}<br>{{ $event->location }}
    </p>
  </div>
</section>


<!-- ===== Sticky Section Nav ===== -->
<nav id="sectionNav" class="sticky top-[72px] z-40 bg-[var(--color-surface)] border-b border-[var(--color-border)] shadow-sm">
  <div class="max-w-6xl mx-auto px-6 flex items-center justify-between py-3 text-sm font-medium text-[var(--color-text-light)]">

    <!-- ===== Left: Event Information Dropdown ===== -->
    <div x-data="{ open: false }" class="relative">
      <button 
        @click="open = !open"
        class="inline-flex items-center gap-2 text-[var(--color-text)] hover:text-[var(--color-primary)] transition"
      >
        Event Information
        <x-heroicon-o-chevron-down 
            class="w-4 h-4 transform transition" 
            x-bind:class="{ 'rotate-180': open }" 
        />
      </button>

      <!-- Dropdown -->
      <div 
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute left-0 mt-3 w-64 bg-[var(--color-surface)] text-left text-[var(--color-text)] rounded-lg shadow-lg overflow-hidden z-50 border border-[var(--color-border)]"
      >
        @if($event_content->count() > 0)
          @foreach($event_content as $content)
            <a href="#section-{{ $content->id }}" 
              @click="open = false"
              class="block px-4 py-2 border-b border-[var(--color-border)] hover:bg-[var(--color-accent-light)] hover:text-[var(--color-primary)] transition">
              {{ $content->title }}
            </a>
          @endforeach
        @endif

        @if($event_downloads->isNotEmpty())
          <a href="#downloads" 
            @click="open = false"
            class="block px-4 py-2 hover:bg-[var(--color-accent-light)] hover:text-[var(--color-primary)] transition">
            Downloads
          </a>
        @endif
      </div>
    </div>

    <!-- ===== Right: Booking Status / Button ===== -->
    <div class="flex-shrink-0">
      @if($event->provisional)
        <div class="p-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-xs sm:text-sm font-medium border border-[var(--color-border)]">
          Registration Opening Soon
        </div>
      @elseif(!$event->is_registerable)
        <div class="p-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-xs sm:text-sm font-medium border border-[var(--color-border)]">
          Booking Closed
        </div>
      @elseif($event->full)
        <div class="p-2 rounded-lg bg-[#DC2626]/90 text-white text-xs sm:text-sm font-semibold uppercase tracking-wide text-center border border-[#DC2626]">
          Course Full
        </div>
      @elseif($event->frontendTickets->isEmpty())
        <div class="p-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-xs sm:text-sm font-medium border border-[var(--color-border)]">
          Booking Coming Soon
        </div>
      @else
        <a href="{{ route('registration', ['event' => $event->id]) }}"
          class="block text-center p-2 px-4 rounded-md text-white font-medium shadow-sm transition"
          style="background:var(--color-primary);">
          Book Now
        </a>
      @endif
    </div>

  </div>
</nav>






<!-- ===== Main Layout ===== -->
<section class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-10">

  <!-- ===== Left: Dynamic Content Panels ===== -->
  <div class="md:col-span-2 space-y-10">
    @if($event_content->count() > 0)
      @foreach ($event_content as $content)
        <div id="section-{{ $content->id }}" class="bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-8">
          <h2 class="text-2xl font-bold text-[var(--color-text-dark)] mb-4 text-left">{{ $content->title }}</h2>
          <div class="prose-content text-left">
            {!! $content->html_content !!}
          </div>
        </div>
      @endforeach
    @else
      <div class="bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-8">
          <h2 class="text-2xl font-bold text-[var(--color-text-dark)] mb-4 text-left">Event information coming soon</h2>
          <div class="prose-content text-left">
            Check back soon for information on this event.
          </div>
        </div>
    @endif

    <!-- ===== Downloads Panel ===== -->
    @if($event_downloads->isNotEmpty())
      <div id="downloads" class="bg-[var(--color-surface)] rounded-xl shadow-sm border border-[var(--color-border)] p-8">
        <h2 class="text-2xl font-bold text-[var(--color-text-dark)] mb-6">Downloads</h2>
        <p class="text-[var(--color-text-dark)] mb-6">
          Useful resources for delegates attending {{ $event->title }}.
        </p>

        <div class="flex flex-col sm:flex-row flex-wrap gap-4">
          @foreach($event_downloads as $download)
            <a href="{{ route('event.download', $download->id) }}" download
               class="flex-1 text-center bg-[var(--color-primary)] text-white font-semibold py-3 rounded-lg transition hover:opacity-90">
              {{ $download->title }}
            </a>
          @endforeach
        </div>
      </div>
    @endif

  </div>

  <!-- ===== Right: Event Summary & Booking Panel ===== -->
<aside id="booking" 
  class="relative md:sticky md:top-44 rounded-xl overflow-hidden border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm h-fit">

  <!-- Header -->
  <div class="px-6 pt-8 pb-6 text-center rounded-t-2xl bg-[var(--color-secondary)]">
    <h3 class="text-lg font-semibold text-white mb-0.5">{{ $event->title }}</h3>
  </div>

  <!-- ===== Status Strip ===== -->
  @if($event->provisional)
    <div class="bg-[var(--color-accent)] text-white text-xs font-semibold uppercase tracking-wide text-center py-2">
      Booking Coming Soon
    </div>
  @elseif(!$event->is_registerable)
    <div class="bg-[var(--color-border)] text-[var(--color-text-light)] text-xs font-semibold uppercase tracking-wide text-center py-2">
      Booking Closed
    </div>
  @elseif($event->full)
    <div class="bg-[#DC2626] text-white text-xs font-semibold uppercase tracking-wide text-center py-2">
      Course Full
    </div>
  @elseif($event->frontendTickets->isNotEmpty())
    <div class="bg-[var(--color-primary)] text-white text-xs font-semibold uppercase tracking-wide text-center py-2">
      Book Now
    </div>
  @else
    <div class="bg-[var(--color-border)] text-[var(--color-text-light)] text-xs font-semibold uppercase tracking-wide text-center py-2">
      Booking Coming Soon
    </div>
  @endif

  <!-- ===== Content ===== -->
  <div class="p-8 space-y-6 text-[var(--color-text)]">
    <div class="text-center">
      <p class="flex items-center gap-2 text-[var(--color-text-light)] text-sm mb-1">
        <x-heroicon-o-calendar class="w-4 h-4" />
        {{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}
      </p>

      <p class="flex items-center gap-2 text-[var(--color-text-light)] text-sm mb-6">
        <x-heroicon-o-map-pin class="w-4 h-4" />
        {{ $event->location }}
      </p>

    </div>

    <!-- Ticket list -->
    @if($event->frontendTickets->isNotEmpty() && $event->is_registerable && !$event->provisional)
      <div x-data="{ showTickets: false }" class="border-t border-[var(--color-border)] pt-4 text-left">
        @foreach($event->frontendTickets as $ticket)
          <div 
            x-show="showTickets || {{ $loop->index }} < 1" 
            x-transition.opacity.duration.200ms
            class="flex justify-between items-baseline text-sm py-1 transition-all duration-300"
          >
            <span class="text-[var(--color-text)]">{{ $ticket->name }}</span>
            <span class="font-semibold text-[var(--color-text)]">
              {{ $currency_symbol }}{{ number_format($ticket->price, 2) }}
              @if($event->vat_percentage > 0)
                <span class="text-xs text-[var(--color-text-light)]">inc VAT</span>
              @endif
            </span>
          </div>
        @endforeach

        @if($event->frontendTickets->count() > 1)
          <button 
            @click="showTickets = !showTickets"
            class="mt-2 text-[var(--color-primary)] text-sm font-medium hover:underline transition"
          >
            <span x-text="showTickets ? 'Hide tickets' : 'Show all tickets'"></span>
          </button>
        @endif
      </div>
    @endif

    <!-- ===== CTA Section ===== -->
    <div class="pt-2">
      @if($event->provisional)
        <div class="mt-6 py-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-sm font-medium border border-[var(--color-border)]">
          Registration Opening Soon
        </div>
      @elseif(!$event->is_registerable)
        <div class="mt-6 py-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-sm font-medium border border-[var(--color-border)]">
          Booking Closed
        </div>
      @elseif($event->full)
        <div class="mt-6 py-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-sm font-medium border border-[var(--color-border)]">
          Registration Closed
        </div>
      @elseif($event->frontendTickets->isEmpty())
        <div class="mt-6 py-2 rounded-lg bg-[var(--color-accent-light)] text-[var(--color-text-light)] text-sm font-medium border border-[var(--color-border)]">
          Booking Coming Soon
        </div>
      @else
        <a href="{{ route('registration', ['event' => $event->id]) }}"
          class="mt-6 w-full block text-center py-2 rounded-lg text-white font-medium shadow-sm transition"
          style="background:var(--color-primary);">
          Book your place
        </a>
      @endif
    </div>
  </div>
</aside>



</section>

<!-- ===== Floating Mobile CTA ===== -->
@if($event->is_registerable)
<a href="{{ route('registration', ['event' => $event->id]) }}"
   class="fixed bottom-5 left-1/2 -translate-x-1/2 bg-[var(--color-primary)] text-[var(--color-surface)] 
          px-6 py-3 rounded-lg font-semibold shadow-lg md:hidden z-50 hover:bg-[var(--color-primary-hover)] transition">
   Book Now
</a>
@endif

@include('livewire.frontend.partials.testimonials')
@endsection
