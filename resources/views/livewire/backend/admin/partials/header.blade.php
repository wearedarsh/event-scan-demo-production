<header
    class="h-16 bg-[var(--color-surface)] border-b border-[var(--color-border)]
           flex items-center justify-between px-6 gap-6">

    <!-- Left side -->
    <div class="flex items-center gap-4">

        <!-- Sidebar toggle -->
        <button id="sidebar-toggle"
            class="flex items-center text-[var(--color-text-light)] hover:text-[var(--color-primary)] transition">
            <x-heroicon-o-bars-3 class="h-5 w-5 mr-2" />
            <span class="hidden sm:inline font-medium">Menu</span>
        </button>

        <!-- Search bar 
        <div class="hidden md:flex items-center relative">
            <x-heroicon-o-magnifying-glass
                class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

            <input type="text"
                   placeholder="Search attendees, personnel, settings…"
                   class="pl-10 pr-4 py-1.5 w-72 rounded-md text-sm
                          bg-[var(--color-surface-muted)]
                          border border-[var(--color-border)]
                          focus:border-[var(--color-primary)]
                          focus:ring-1 focus:ring-[var(--color-primary)]
                          transition" />
        </div> -->
    </div>

    <!-- Right side -->
    <div class="flex items-center gap-4">

        <!-- Settings -->
        <a href="{{route('admin.settings.index')}}"
           class="text-[var(--color-text-light)] hover:text-[var(--color-primary)] transition">
            <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
        </a>
        <x-admin.outline-btn-icon
            :href="route('logout')"
            icon="heroicon-o-arrow-right-on-rectangle">
            Logout
        </x-admin.outline-btn-icon>
    </div>

</header>
