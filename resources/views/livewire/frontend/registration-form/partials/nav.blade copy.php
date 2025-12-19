<header 
    x-data="{ open: false, eventsOpen: false }"
    class="bg-[var(--color-surface)] shadow-sm fixed w-full z-50"
>
  <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-3">
      <img src="{{ asset('images/frontend/logo.png') }}" width="200" alt="{{ config('customer.contact_details.booking_website_company_name" />
    </a>

    <div class="hidden md:flex items-center gap-8">

        <!-- ===== Auth Buttons ===== -->
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


</header>
