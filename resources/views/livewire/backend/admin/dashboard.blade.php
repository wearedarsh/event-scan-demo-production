<div class="">
    <!-- Header -->
    <div class="my-2 mb-4">
        <x-admin.page-header
            title="Welcome, {{ Auth::user()->first_name }}"
            subtitle="Quick overview and tools for managing your events.">
            
            <x-admin.outline-btn-icon
                :href="route('admin.events.create')"
                icon="heroicon-o-plus">
                Create event
            </x-admin.outline-btn-icon>

        </x-admin.page-header>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6 px-6">

        <!-- Events -->
        <x-admin.tile-card
            title="Events"
            icon="heroicon-o-calendar-days"
            :micro="['title' => 'Primary Actions']"
            description="Manage your existing events or create new ones.">

            <x-link-arrow href="{{ route('admin.events.index') }}">
                Manage events
            </x-link-arrow><br>

            <x-link-arrow href="{{ route('admin.events.create') }}" class="mt-1">
                Create event
            </x-link-arrow>

        </x-admin.tile-card>


        <!-- Settings -->
        <x-admin.tile-card
            icon="heroicon-o-cog-6-tooth"
            title="Settings"
            description="Manage your team members and website content."
            :micro="[
        'title' => 'Primary Actions']">

            <x-link-arrow href="{{ route('admin.users.index') }}">
                Team members
            </x-link-arrow><br>

            <x-link-arrow href="{{ route('admin.website.index') }}" class="mt-1">
                Website
            </x-link-arrow>

        </x-admin.tile-card>


        

    </div>
    
    <div class="px-6 pt-4">
        <x-admin.action-card
        icon="heroicon-o-qr-code"
            title="Check-in app"
            description="Install the mobile check-in app for Android or iOS.">

            <x-link-arrow href="{{ route('admin.app.index') }}">
                Install app
            </x-link-arrow>

        </x-admin.action-card>
    </div>

</div>
