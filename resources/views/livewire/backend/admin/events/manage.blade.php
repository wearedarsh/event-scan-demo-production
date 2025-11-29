<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="{{ $event->title }}"
        subtitle="{{ $event->formatted_start_date }} – {{ $event->formatted_end_date }}">

        <!-- Top Stats -->
        <div class="flex flex-wrap md:flex-nowrap items-center gap-3">
            <!-- Link + Copy -->
            <x-admin.stat-card label="Link">
                <!-- Copy to clipboard -->
                <x-admin.icon-link
                    icon="heroicon-o-clipboard"
                    @click="copyToClipboard('{{ route('event', ['event' => $event->id]) }}'); $dispatch('copied')">
                    Copy
                </x-admin.icon-link>
                <!-- View -->
                <x-admin.icon-link
                    href="{{ route('event', $event->id) }}"
                    icon="heroicon-o-arrow-top-right-on-square"
                    right
                    target="_blank">
                    View
                </x-admin.icon-link>
            </x-admin.stat-card>

            <!-- Status -->
            <x-admin.stat-card label="Status">
                <x-admin.toggle
                    :active="$event->active"
                    show-label="true"
                    label-on="Active"
                    label-off="Inactive"
                    wire:click="toggleActive" />
            </x-admin.stat-card>

            <!-- Attendees -->
            <x-admin.stat-card
                label="Attendees"
                :value="$event->attendees->count()" />

            <!-- Unpaid -->
            <x-admin.stat-card
                label="Unpaid"
                type="warning"
                :value="$event->registrations->count()" />
        </div>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif

    <div class="px-6 space-y-4">

        <!-- Settings -->
        <x-admin.section-title title="Settings" />
        <x-admin.action-card
            title="General Settings"
            description="Core event details such as title, dates, visibility, and pricing."
        >
            <x-link-arrow href="{{ route('admin.events.edit', $event->id) }}">Edit settings</x-link-arrow>
        </x-admin.action-card>

        <!-- Primary actions -->
        <x-admin.section-title title="Primary actions" />
        <!-- Row: 3 columns -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- People -->
            <x-admin.tile-card
                title="People"
                description="Manage attendees, registrations, and personnel."
            >
                <x-link-arrow href="{{ route('admin.events.attendees.index', $event->id) }}">
                    Attendees
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.registrations.index', $event->id) }}">
                    Registrations
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.personnel.index', $event->id) }}">
                    Personnel
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Content -->
            <x-admin.tile-card
                title="Content"
                description="Manage sessions, tickets, and website content."
            >
                <x-link-arrow href="{{ route('admin.events.event-sessions.index', $event->id) }}">
                    Manage sessions
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.tickets.index', $event->id) }}">
                    Manage tickets
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.content.index', $event->id) }}">
                    Manage website content
                </x-link-arrow>
            </x-admin.tile-card>
        </div>

        <!-- Badges -->
        <x-admin.action-card
            title="Badges"
            description="Print-ready badges and blank badge templates."
        >
            <x-link-arrow href="{{ route('admin.events.attendees.badges.export', $event->id) }}">
                Print badges
            </x-link-arrow>

            <x-link-arrow href="{{ route('admin.events.attendees.blank-badge.export', $event->id) }}">
                Blank badge
            </x-link-arrow>
        </x-admin.action-card>

        <!-- Event content -->
        <x-admin.section-title title="Event content" />
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Communication -->
            <x-admin.tile-card
                title="Communication"
                description="Send targeted email messages to attendees or registrants."
            >
                <x-link-arrow href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'attendees_paid']) }}">
                    Email paid attendees
                </x-link-arrow><br>
                <x-link-arrow href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'registrations_unpaid']) }}">
                    Email unpaid registrations
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Downloads -->
            <x-admin.tile-card
                title="Downloads"
                description="Export attendee requirements and payment information."
            >
                <x-link-arrow href="#" wire:click.prevent="exportAttendeeSpecialRequirements">
                    Attendee requirements XLSX
                </x-link-arrow><br>
                <x-link-arrow href="{{ route('admin.events.reports.payments.export', $event->id) }}">
                    Payment data XLSX
                </x-link-arrow>
            </x-admin.tile-card>


            <!-- Feedback & Analytics -->
            <x-admin.tile-card
                title="Feedback & Analytics"
                description="Manage feedback forms and access reporting tools."
            >
                <x-link-arrow href="{{ route('admin.events.feedback-form.index', $event->id) }}">
                    Manage feedback
                </x-link-arrow><br>

                <x-link-arrow href="{{ route('admin.events.reports.index', $event->id) }}">
                    View reports
                </x-link-arrow>
            </x-admin.tile-card>
        </div>

        <!-- Check in app -->
        <x-admin.action-card
            title="Check-In App"
            description="Set up your mobile app and manage manual check-ins."
        >
            <x-link-arrow href="{{ route('admin.app.index') }}">
                Install app
            </x-link-arrow>

            <x-link-arrow href="{{ route('admin.events.manual-check-in.groups', $event->id) }}">
                Manual guestlist
            </x-link-arrow>
        </x-admin.action-card>

    </div>

</div>