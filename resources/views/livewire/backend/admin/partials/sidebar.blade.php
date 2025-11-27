<aside id="sidebar"
    class="w-64 bg-[var(--color-surface)] text-[var(--color-text)]
           border-r border-[var(--color-border)]
           fixed inset-y-0 left-0 z-40 flex flex-col
           transition-transform duration-300 ease-in-out
           -translate-x-64">

    <!-- Logo (64px tall to match header) -->
    <div class="h-16 px-3 flex items-center border-b border-[var(--color-border)]">
        <a href="{{ route('admin.dashboard') }}" class="opacity-90 hover:opacity-100 transition">
            <img src="{{ asset('images/backend/logo.png') }}" width="200" class="object-contain" />
        </a>
    </div>

    <!-- HOME -->
<x-admin.sidebar-link
    label="Home"
    href="{{ route('admin.dashboard') }}"
    icon="home"
    :active="request()->routeIs('admin.dashboard')"
/>

<x-admin.sidebar-separator />

<!-- EVENTS -->
<x-admin.sidebar-heading label="Your events" />

<x-admin.sidebar-link
    label="Manage"
    href="{{ route('admin.events.index') }}"
    icon="calendar"
    :active="request()->routeIs('admin.events.*')"
/>

<x-admin.sidebar-separator />

<!-- SETTINGS -->
<x-admin.sidebar-heading label="Settings" />

<x-admin.sidebar-link
    label="Team members"
    href="{{ route('admin.users.index') }}"
    icon="users"
    :active="request()->routeIs('admin.users.*')"
/>

<x-admin.sidebar-link
    label="Website"
    href="{{ route('admin.website.index') }}"
    icon="cog-6-tooth"
    :active="request()->routeIs('admin.website.*')"
/>

<x-admin.sidebar-separator />

<!-- EMAIL -->
<x-admin.sidebar-heading label="Email" />

<x-admin.sidebar-link
    label="Signatures"
    href="{{ route('admin.emails.signatures.index') }}"
    icon="pencil"
    :active="request()->routeIs('admin.emails.signatures.*')"
/>

<x-admin.sidebar-link
    label="Templates"
    href="{{ route('admin.emails.templates.index') }}"
    icon="document-text"
    :active="request()->routeIs('admin.emails.templates.*')"
/>

<x-admin.sidebar-separator />

<!-- CHECK-IN -->
<x-admin.sidebar-heading label="Check-In App" />

<x-admin.sidebar-link
    label="Install"
    href="{{ route('admin.app.index') }}"
    icon="device-phone-mobile"
    :active="request()->routeIs('admin.app.*')"
/>


</aside>
