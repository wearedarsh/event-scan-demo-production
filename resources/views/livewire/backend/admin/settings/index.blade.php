<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Settings'],
    ]" />

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Settings</h1>
    </div>

    <div class="px-6">
        <x-admin.section-title title="Manage settings" />
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-6">

        <!-- Team Members -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
            <h3 class="font-medium mb-2">Team members</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-2">
                Manage admin users and permissions.
            </p>

            <x-link-arrow href="{{ route('admin.users.index') }}">
                Manage team
            </x-link-arrow>
        </div>

        <!-- Website -->
        <div class="soft-card p-5 hover:shadow-md hover:-translate-y-0.5 transition">
            <h3 class="font-medium mb-2">Website content</h3>
            <p class="text-sm text-[var(--color-text-light)] mb-2">
                Manage your public-facing website.
            </p>

            <x-link-arrow href="{{ route('admin.website.index') }}">
                Manage website
            </x-link-arrow>
        </div>

    </div>


    <!-- Full-width Check-In App -->
    <div class="px-6">
        <div class="soft-card p-5 flex items-center justify-between hover:shadow-md hover:-translate-y-0.5 transition">

            <div>
                <h3 class="font-medium">Check-In App</h3>
                <p class="text-sm text-[var(--color-text-light)]">
                    Install the branded iOS & Android app for your events.
                </p>
            </div>

            <x-link-arrow href="{{ route('admin.app.index') }}">
                Install
            </x-link-arrow>

        </div>
    </div>

</div>