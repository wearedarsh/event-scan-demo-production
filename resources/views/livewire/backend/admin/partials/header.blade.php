<header
    class="h-16 bg-[var(--color-surface)] border-b border-[var(--color-border)]
           flex items-center justify-between px-6 gap-6">

    <!-- Left side -->
    <div class="flex items-center gap-4">

        <!-- Sidebar toggle -->
        <button id="sidebar-toggle-open"
            class=" lg:hidden flex items-center text-[var(--color-text-light)] hover:text-[var(--color-primary)] transition">
            <x-heroicon-o-bars-3 class="h-6 w-6 mr-2" />
            
        </button>

        <div class="hidden lg:block w-full ml-1 flex items-center">
            <livewire:backend.admin.header-search />
        </div>
    </div>

    <!-- Right side -->
    <div class="flex items-center gap-4">


        <!-- Settings -->
        <x-admin.tooltip text="Settings">
            <x-admin.icon-button 
                icon="heroicon-o-cog-6-tooth" 
                href="{{ route('admin.settings.index') }}"
            />
        </x-admin.tooltip>

        <x-admin.outline-btn-icon
            :href="route('logout')"
            icon="heroicon-o-arrow-right-on-rectangle">
            Logout
        </x-admin.outline-btn-icon>
    </div>

</header>
