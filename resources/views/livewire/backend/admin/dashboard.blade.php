<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Welcome, {{ Auth::user()->first_name }}</h1>
        </div>

        <!-- Right: Create Event -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.create') }}"
               class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                      bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                      text-[var(--color-primary)]
                      hover:bg-[var(--color-primary)] hover:text-white
                      transition-colors duration-150">
                <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                <span class="hidden md:inline">Create event</span>
            </a>
        </div>
    </div>

    <div class="px-6">
        <x-admin.section-title title="Quick links" />
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6">

        <!-- Events -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition block">
            <h3 class="font-medium mb-2">Events</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-2">Manage and create events.</p>

            <x-link-arrow href="{{ route('admin.events.index') }}">
                Manage
            </x-link-arrow><br>

            <x-link-arrow href="{{ route('admin.events.create') }}">
                Create
            </x-link-arrow>
        </div>

        <!-- Settings -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition block">
            <h3 class="font-medium mb-2">Settings</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-2">Manage your team and website.</p>

            <x-link-arrow href="{{ route('admin.users.index') }}">
                Team members
            </x-link-arrow><br>

            <x-link-arrow href="{{ route('admin.website.index') }}">
                Website
            </x-link-arrow>
        </div>

        <!-- Check-In App -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition block">
            <h3 class="font-medium mb-2">Check-in app</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-2">Download for Android or Apple.</p>

            <x-link-arrow href="{{ route('admin.app.index') }}">
                Install
            </x-link-arrow>
        </div>

    </div>

</div>
