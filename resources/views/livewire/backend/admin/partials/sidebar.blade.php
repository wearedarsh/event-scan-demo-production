<aside id="sidebar"
    class="
        w-60 bg-[var(--color-surface)] text-[var(--color-text)]
        border-r border-[var(--color-border)]
        fixed lg:static inset-y-0 left-0 z-40 flex flex-col
        transform transition-transform duration-300 ease-in-out
        -translate-x-full lg:translate-x-0

        md:border-r md:rounded-none
        rounded-r-xl shadow-xl
        md:shadow-none 
    ">
    <div class="h-16 px-3 flex items-center justify-between border-b border-[var(--color-border)]">

        <a href="{{ route('admin.dashboard') }}"
            class="opacity-90 hover:opacity-100 transition flex items-center">

            <img
                src="{{ asset('images/backend/logo.png') }}"
                class="object-contain
                       w-40 lg:w-50"
            alt="Logo"
            />
        </a>

        <button id="sidebar-toggle-close"
            class="
                lg:hidden flex items-center gap-2
                text-[var(--color-text-light)]
                hover:text-[var(--color-primary)]
                bg-[var(--color-primary)]/5
                px-2 py-2 rounded-md 
                transition
            ">
            <x-heroicon-o-x-mark class="h-5 w-5" />
        </button>
    </div>

    <!-- HOME -->
    <x-admin.sidebar-link
        label="Home"
        href="{{ route('admin.dashboard') }}"
        icon="home"
        :active="request()->routeIs('admin.dashboard')" />

    <x-admin.sidebar-separator />

    <!-- EVENTS -->
    <x-admin.sidebar-heading label="Events" />

    <x-admin.sidebar-link
        label="Manage"
        href="{{ route('admin.events.index') }}"
        icon="calendar"
        :active="request()->routeIs('admin.events.*')" />

    <x-admin.sidebar-separator />

    <!-- SETTINGS -->
    <x-admin.sidebar-heading label="Settings" />

    <x-admin.sidebar-link
        label="Team members"
        href="{{ route('admin.users.index') }}"
        icon="users"
        :active="request()->routeIs('admin.users.*')" />

    <x-admin.sidebar-link
        label="Website"
        href="{{ route('admin.website.index') }}"
        icon="cog-6-tooth"
        :active="request()->routeIs('admin.website.*')" />

    <x-admin.sidebar-separator />

    <!-- EMAIL -->
    <x-admin.sidebar-heading label="Email" />

    <x-admin.sidebar-link
        label="Signatures"
        href="{{ route('admin.emails.signatures.index') }}"
        icon="pencil"
        :active="request()->routeIs('admin.emails.signatures.*')" />

    <x-admin.sidebar-link
        label="Templates"
        href="{{ route('admin.emails.templates.index') }}"
        icon="document-text"
        :active="request()->routeIs('admin.emails.templates.*')" />

    <x-admin.sidebar-separator />

    <!-- CHECK-IN -->
    <x-admin.sidebar-heading label="Check-In App" />

    <x-admin.sidebar-link
        label="Install"
        href="{{ route('admin.app.index') }}"
        icon="device-phone-mobile"
        :active="request()->routeIs('admin.app.*')" />


</aside>