<header 
    x-data="{ open: false, eventsOpen: false }"
    class="bg-[var(--color-surface)] shadow-sm fixed w-full z-50"
>
  <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-3">
      <img src="{{ asset('images/frontend/logo.png') }}" width="200" alt="{{ config('customer.contact_details.booking_website_company_name" />
    </a>

    <!-- RIGHT SIDE: Events dropdown + auth buttons -->
    <div class="hidden md:flex items-center gap-8">

        <!-- ===== Events Dropdown ===== -->
        <div x-data="{ open: false }" class="relative">
            <button 
              @click="open = !open"
              class="inline-flex items-center gap-2 text-sm text-[var(--color-text)] hover:text-[var(--color-primary)] transition"
            >
              {!! client_setting('booking.nav.dropdown_title') !!}
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
              class="absolute right-0 mt-3 w-72 bg-[var(--color-surface)] 
                     text-left text-[var(--color-text)] rounded-lg shadow-lg 
                     overflow-hidden z-50"
            >
                @if($events->count() > 0)
                    @foreach($events as $event)
                        <a href="{{ route('event', ['event' => $event->id]) }}" 
                           class="block p-4 border-b border-[var(--color-border)] hover:bg-[var(--color-accent-light)] hover:text-[var(--color-primary)] transition">
                            <div class="font-medium text-[var(--color-text)]">
                              {{ $event->title }}
                            </div>
                            <div class="flex flex-col gap-1 mt-1 text-xs text-[var(--color-muted)]">
                              <div class="flex items-center gap-1.5">
                                <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                                <span>{{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}</span>
                              </div>
                              <div class="flex items-center gap-1.5">
                                <x-heroicon-o-map-pin class="w-3.5 h-3.5" />
                                <span>{{ $event->location }}</span>
                              </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <span class="block px-4 py-2 text-sm text-[var(--color-text-light)]">No events</span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4">
          @if(Auth::check())
              @php
                  $user = Auth::user();
                  $role = $user->role?->key_name;
              @endphp

              <a href="{{ $user->is_admin ? ($role === 'app_user' ? route('admin.app.index') : route('admin.dashboard')) : route('customer.dashboard') }}"
                 class="px-4 py-2 rounded-lg text-sm font-semibold border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition">
                Dashboard
              </a>

              <a href="{{ route('logout') }}"
                 class="px-4 py-2 rounded-lg text-sm font-semibold border border-[var(--color-border)] text-[var(--color-text-light)] hover:bg-[var(--color-accent-light)] transition">
                Logout
              </a>
          @else
              <a href="{{ route('login') }}"
                 class="inline-flex items-center text-sm px-4 py-2 rounded-lg font-semibold text-white shadow-sm transition"
                 style="background: var(--color-primary);">
                Login
              </a>
          @endif
        </div>

    </div>

    <!-- ===== Mobile Menu Button ===== -->
    <button 
      @click="open = !open" 
      class="md:hidden w-10 h-10 flex items-center justify-center text-[var(--color-primary)] rounded-lg hover:bg-[var(--color-accent-light)]"
    >
      <template x-if="!open">
        <x-heroicon-o-bars-3 class="w-6 h-6" />
      </template>
      <template x-if="open">
        <x-heroicon-o-x-mark class="w-6 h-6" />
      </template>
    </button>
  </div>

  <!-- ===== Mobile Menu Overlay ===== -->
  <div 
    x-show="open"
    x-transition
    class="fixed inset-0 bg-[var(--color-secondary)] bg-opacity-95 flex flex-col text-[var(--color-surface)] md:hidden z-40"
  >
    <!-- Close Button -->
    <button 
      @click="open = false" 
      class="absolute top-5 right-5 text-[var(--color-surface)] hover:text-[var(--color-accent)]"
    >
      <x-heroicon-o-x-mark class="w-7 h-7" />
    </button>

    <!-- Scrollable Container -->
    <div class="flex flex-col overflow-y-auto h-full px-6 pt-20 pb-10 space-y-10">

      <!-- ===== Auth Buttons (Always Visible at Top) ===== -->
      <div class="flex flex-col items-start space-y-4">
        @if(Auth::check())
            @php
                $user = Auth::user();
                $role = $user->role?->key_name;
            @endphp
            <a href="{{ $user->is_admin ? ($role === 'app_user' ? route('admin.app.index') : route('admin.dashboard')) : route('customer.dashboard') }}" 
                class="block w-full bg-[var(--color-surface)] text-[var(--color-primary)] px-4 py-2 rounded-lg text-sm font-medium text-center hover:bg-[var(--color-accent-light)] transition">
                Dashboard
            </a>

            <a href="{{ route('logout') }}" 
                class="block w-full border border-[var(--color-surface)] text-[var(--color-surface)] px-4 py-2 text-sm rounded-lg font-medium text-center hover:bg-[var(--color-primary)] hover:text-[var(--color-primary)] transition">
                Logout
            </a>
        @else
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white shadow"
                style="background: var(--color-primary);">
                Login
            </a>
        @endif
      </div>

      <!-- ===== Navigation Links ===== -->
      <nav class="flex flex-col items-start text-left space-y-6 text-xl font-medium">
        <!-- Our Events Dropdown -->
        <div x-data="{ mobileEvents: false, showAllEvents: false }" class="w-full">
          <button 
            @click="mobileEvents = !mobileEvents"
            class="flex items-center gap-2 font-semibold text-[var(--color-surface)] hover:text-[var(--color-accent)] transition"
          >
            Our Events
            <x-heroicon-o-chevron-down 
                class="w-4 h-4 transform transition" 
                x-bind:class="{ 'rotate-180': mobileEvents }" 
            />
          </button>

          <div 
            x-show="mobileEvents" 
            x-transition 
            class="mt-3 text-[var(--color-surface)] overflow-hidden w-full"
          >
            @if($events->count() > 0)
              <template x-for="(event, index) in {{ $events->toJson() }}" :key="event.id">
                <div x-show="showAllEvents || index < 6">
                  <a :href="'/event/' + event.id" 
                    class="block px-2 border-b border-[var(--color-border)]/10 py-3 text-sm font-medium hover:text-[var(--color-accent)] transition">
                    
                    <span x-text="event.title"></span><br>

                    <!-- Date line -->
                    <span class="text-xs opacity-75 flex items-center gap-1 mt-0.5">
                      <x-heroicon-o-calendar class="w-3.5 h-3.5 text-[var(--color-accent)] flex-shrink-0" />
                      <span x-text="event.formatted_start_date + ' - ' + event.formatted_end_date"></span>
                    </span>

                    <!-- Location line -->
                    <span class="text-xs opacity-75 flex items-center gap-1 mt-0.5">
                      <x-heroicon-o-map-pin class="w-3.5 h-3.5 text-[var(--color-accent)] flex-shrink-0" />
                      <span x-text="event.location"></span>
                    </span>
                    
                  </a>
                </div>
              </template>


              @if($events->count() > 6)
                <button 
                  @click="showAllEvents = !showAllEvents"
                  class="mt-3 text-sm text-[var(--color-accent)] hover:underline transition">
                  <span x-text="showAllEvents ? 'Show Less' : 'Show More'"></span>
                </button>
              @endif
            @else
                <span class="block px-4 py-2 text-sm text-[var(--color-text-light)]">No events</span>
            @endif
          </div>
        </div>

        <!-- <a href="#testimonials" @click="open = false" class="hover:text-[var(--color-accent)] transition">Testimonials</a>
        <a href="#footer" @click="open = false" class="hover:text-[var(--color-accent)] transition">Contact</a> -->
      </nav>
    </div>
  </div>

</header>
