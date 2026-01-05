@extends('livewire.frontend.layouts.app')

@section('content')
<div class="relative bg-[var(--color-bg)]">
  @include('livewire.frontend.partials.nav')

  <section class="relative pt-32 pb-24 text-center overflow-hidden">
    <div 
      class="absolute inset-0 bg-cover bg-center" 
      style="background-image: url('{{ asset('images/frontend/header-bg.jpg') }}');"
    ></div>

    <div class="relative max-w-3xl mx-auto px-6 text-[var(--color-surface)]">
      {!! client_setting('booking.hero.header_html') !!}
    </div>
  </section>
</div>

<section id="our-events" class="py-24 bg-[var(--color-bg)]">
  <div class="max-w-6xl mx-auto px-6 text-center mb-12">
    {!! client_setting('booking.events.header_html') !!}
  </div>

  <div x-data="{ showAll: false }" class="max-w-6xl mx-auto px-6">
    @if($events->isNotEmpty())
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($events as $index => $event)
          <div 
            x-show="showAll || {{ $index }} < 3"
            x-data="{ showTickets: false }"
            class="group relative flex flex-col rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden"
          >
            <!-- Header -->
            <div class="px-6 pt-8 pb-6 text-center rounded-t-2xl bg-[var(--color-secondary)]">
              <h3 class="text-lg font-semibold text-white mb-0.5">{{ $event->title }}</h3>
            </div>

            <!-- Status Strip -->
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

            <!-- Body -->
            <div class="p-8 flex flex-col flex-1 text-center">
              <p class="flex items-center gap-2 text-[var(--color-text-light)] text-sm mb-1">
                <x-heroicon-o-calendar class="w-4 h-4" />
                {{ $event->formatted_start_date }} - {{ $event->formatted_end_date }}
              </p>

              <p class="flex items-center gap-2 text-[var(--color-text-light)] text-sm mb-6">
                <x-heroicon-o-map-pin class="w-4 h-4" />
                {{ $event->location }}
              </p>


              @if($event->frontendTickets->isNotEmpty() && $event->is_registerable && !$event->provisional)
                <div class="border-t border-[var(--color-border)] pt-4 text-left">
                  @foreach($event->frontendTickets as $ticket)
                    <div 
                      x-show="showTickets || {{ $loop->index }} < 1" 
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

              <!-- CTA -->
              <div class="mt-auto">
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
                    Book Your Place
                  </a>
                @endif

                <a href="{{ route('event', ['event' => $event->id]) }}"
                  class="mt-5 inline-flex text-sm items-center justify-center gap-2 text-[var(--color-primary)] font-medium hover:underline">
                  More Info
                  <x-heroicon-o-arrow-right class="w-4 h-4" />
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- View More / View Less --}}
      @if($events->count() > 6)
        <div class="mt-10 text-sm text-center">
          <button 
            @click="showAll = !showAll"
            class="font-semibold text-[var(--color-primary)] hover:underline focus:outline-none"
          >
            <span x-text="showAll ? 'View Less' : 'View More'"></span>
          </button>
        </div>
      @endif
    @else
      <div class="text-center text-[var(--color-text-light)] mt-16">
        No events available yet.
      </div>
    @endif
  </div>
</section>





@include('livewire.frontend.partials.testimonials')
@endsection
