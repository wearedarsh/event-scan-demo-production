<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Reports"
        subtitle="View reporting and analytics for this event."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Attendee Reports (top action card) -->
    <div class="px-6">
        <x-admin.action-card
            title="Attendee reports"
            description="View and export all attendees for this event."
        >
            <x-link-arrow href="{{ route('admin.events.reports.attendees.view', $event->id) }}">
                View attendees
            </x-link-arrow>
        </x-admin.action-card>
    </div>


    <!-- Tile cards -->
    <div class="px-6 space-y-4">

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Feedback -->
            <x-admin.tile-card
                title="Feedback forms"
                description="View feedback responses submitted by attendees."
            >
                <x-link-arrow href="{{ route('admin.events.reports.feedback.index', $event->id) }}">
                    View feedback
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Demographics -->
            <x-admin.tile-card
                title="Demographics"
                description="See demographic breakdowns for attendees."
            >
                <x-link-arrow href="{{ route('admin.events.reports.demographics.view', $event->id) }}">
                    View demographics
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Financial -->
            <x-admin.tile-card
                title="Financial"
                description="Review revenue, orders, and financial activity."
            >
                <x-link-arrow href="{{ route('admin.events.reports.financial.view', $event->id) }}">
                    View financial report
                </x-link-arrow>
            </x-admin.tile-card>

            <!-- Check-ins -->
            <x-admin.tile-card
                title="Check-ins"
                description="Analyse check-in activity and scanning performance."
            >
                <x-link-arrow href="{{ route('admin.events.reports.checkin.view', $event->id) }}">
                    View check-in activity
                </x-link-arrow>
            </x-admin.tile-card>

        </div>

    </div>

</div>
