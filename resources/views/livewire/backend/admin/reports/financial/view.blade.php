<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Financial'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Financial Report"
        subtitle="{{ $event->title }}"
    />

    <!-- Filters -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">
            <x-admin.section-title title="Filters" />

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="form-label-custom">Date from</label>
                    <x-admin.input-text type="date" model="date_from" class="w-full" />
                </div>

                <div>
                    <label class="form-label-custom">Date to</label>
                    <x-admin.input-text type="date" model="date_to" class="w-full" />
                </div>

            </div>
        </x-admin.card>
    </div>

    <!-- Tools -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">
            <x-admin.section-title title="Tools" />

            <div class="flex flex-wrap items-center gap-3">

                <x-admin.outline-btn-icon
                    icon="heroicon-o-arrow-down-tray"
                    :href="route('admin.events.reports.financial.pdf.export', $event->id) . '?date_from=' . $date_from . '&date_to=' . $date_to">
                    Export PDF
                </x-admin.outline-btn-icon>

                <x-admin.outline-btn-icon
                    icon="heroicon-o-arrow-down-tray"
                    :href="route('admin.events.reports.payments.export', $event->id) . '?date_from=' . $date_from . '&date_to=' . $date_to">
                    Export all payment data (XLSX)
                </x-admin.outline-btn-icon>

            </div>
        </x-admin.card>
    </div>

    <!-- Totals -->
    <div class="px-6">
        <x-admin.card class="p-6">
            <x-admin.section-title title="Overview" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <x-admin.stat-card
                    label="Paid attendees"
                    :value="$report['totals']['attendees'] ?? 0"
                />

                <x-admin.stat-card
                    label="Registrations (unpaid)"
                    type="warning"
                    :value="$report['totals']['registrations'] ?? 0"
                />

                <x-admin.stat-card
                    label="Total revenue"
                    :value="'€' . number_format($report['totals']['revenue'] ?? 0, 2)"
                />

            </div>
        </x-admin.card>
    </div>

    <!-- Tickets -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">
            <x-admin.section-title title="Tickets" />

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Chart: Quantity -->
                <x-reports.chart-block
                    id="chart-tickets-count"
                    label="Quantity"
                />

                <!-- Ticket list -->
                <x-reports.list
                    :labels="($report['tickets']['labels'] ?? [])"
                    :counts="($report['tickets']['counts'] ?? [])"
                    :totals="($report['tickets']['totals'] ?? [])"
                    currency="€"
                />

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Chart: Value -->
                <x-reports.chart-block
                    id="chart-tickets-value"
                    label="Value"
                />

            </div>

        </x-admin.card>
    </div>

    <!-- Payment Methods -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">
            <x-admin.section-title title="Payment methods" />

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Payment totals chart -->
                <x-reports.chart-block
                    id="chart-payments-value"
                    label="Total value"
                />

                <!-- Payment totals list -->
                <x-reports.list
                    :labels="($report['payments']['labels'] ?? [])"
                    :counts="($report['payments']['counts'] ?? [])"
                    :totals="($report['payments']['totals'] ?? [])"
                    currency="€"
                />

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Payment count chart -->
                <x-reports.chart-block
                    id="chart-payments-count"
                    label="Count"
                />

            </div>

        </x-admin.card>
    </div>

    <x-reports.charts-js :charts="$charts" event="financial-charts:update" />

</div>
