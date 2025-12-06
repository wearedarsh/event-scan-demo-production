<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Settings'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Settings"
        subtitle="Manage your team, website and app settings." />


    <!-- Manage Settings -->
    <div class="px-6">
        <x-admin.section-title title="Manage settings" />
    </div>

    <!-- Tile Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-6">

        <!-- Team Members -->
        <x-admin.tile-card
            title="Team members"
            description="Manage admin users and permissions.">

            <x-link-arrow href="{{ route('admin.users.index') }}">
                Manage team
            </x-link-arrow>

        </x-admin.tile-card>


        <!-- Website Content -->
        <x-admin.tile-card
            title="Website content"
            description="Manage your public-facing website.">

            <x-link-arrow href="{{ route('admin.website.index') }}">
                Manage website
            </x-link-arrow>

        </x-admin.tile-card>

    </div>


    <!-- Check-In App (Action Card) -->
    <div class="px-6">
        <x-admin.action-card
            title="Check-in app"
            description="Install the branded iOS & Android app for your events.">

            <x-link-arrow href="{{ route('admin.app.index') }}">
                Install
            </x-link-arrow>

        </x-admin.action-card>
    </div>

</div>
