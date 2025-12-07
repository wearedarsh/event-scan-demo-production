<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Demographics'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Demographics Report"
        subtitle="{{ $event->title }}"
    />

    <!-- Tools -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Tools" />

            <div class="flex flex-wrap items-center gap-3">
                <x-admin.outline-btn-icon
                    icon="heroicon-o-arrow-down-tray"
                    :href="route('admin.events.reports.demographics.pdf.export', $event->id)">
                    Export PDF
                </x-admin.outline-btn-icon>
            </div>
        </x-admin.card>
    </div>

    <!-- Attendee Type -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">
            <x-admin.section-title title="Medical Attendee Type" />

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Chart -->
                <x-reports.chart-block
                    id="chart-attendeeType"
                    label="Attendee Type"
                />

                <!-- List -->
                <x-reports.list
                    :labels="$report['attendeeType']['labels'] ?? []"
                    :counts="$report['attendeeType']['counts'] ?? []"
                    :totals="$report['attendeeType']['percentages'] ?? []"
                    type="percentage"
                />

            </div>
        </x-admin.card>
    </div>

    <!-- Country -->
    <div class="px-6 mb-8">
        <x-admin.card class="p-6 space-y-6">
            <x-admin.section-title title="Country" />

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Chart -->
                <x-reports.chart-block
                    id="chart-country"
                    label="Country"
                />

                <!-- List -->
                <x-reports.list
                    :labels="$report['country']['labels'] ?? []"
                    :counts="$report['country']['counts'] ?? []"
                    :totals="$report['country']['percentages'] ?? []"
                    type="percentage"
                />

            </div>
        </x-admin.card>
    </div>

    <x-reports.charts-js :charts="$charts" event="demographics-charts:update" />

</div>
