<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Check-ins'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Check-ins Report"
        subtitle="{{ $event->title }}"
    />


    <!-- Tools -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Tools" />

            <div class="flex flex-wrap items-center gap-3">

                <x-admin.outline-btn-icon
                    icon="heroicon-o-arrow-down-tray"
                    :href="route('admin.events.reports.checkin.pdf.export', $event->id)">
                    Export PDF
                </x-admin.outline-btn-icon>

            </div>

        </x-admin.card>
    </div>


    <!-- Check-ins by route -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Check-ins by route" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Route</th>
                            <th class="px-4 py-3 text-right">Check-ins</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($report['by_route'] ?? [] as $route => $count)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]">
                                <td class="px-4 py-3">{{ ucfirst($route) }}</td>
                                <td class="px-4 py-3 text-right">{{ $count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No check-ins recorded.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>
    </div>


    <!-- Check-ins by user -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Check-ins by user" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3 text-right">Check-ins</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($report['by_user'] ?? [] as $row)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]">
                                <td class="px-4 py-3">{{ $row['label'] }}</td>
                                <td class="px-4 py-3 text-right">{{ $row['count'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No check-ins found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>
    </div>


    <!-- Session groups -->
    @foreach($report['by_groups'] ?? [] as $group)
        <div class="px-6">
            <x-admin.card class="p-6 space-y-4">

                <x-admin.section-title :title="$group['group']" />

                <x-admin.table>
                    <table class="min-w-full text-sm text-left">

                        <thead>
                            <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                                <th class="px-4 py-3">Session</th>
                                <th class="px-4 py-3 text-right">Check-ins</th>
                                <th class="px-4 py-3 text-right">% of all attendees</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($group['rows'] ?? [] as $row)
                                <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)]">
                                    <td class="px-4 py-3">{{ $row['session'] }}</td>
                                    <td class="px-4 py-3 text-right">{{ $row['count'] }}</td>
                                    <td class="px-4 py-3 text-right">{{ number_format($row['pct'], 1) }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                        No sessions found in this group.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </x-admin.table>

            </x-admin.card>
        </div>
    @endforeach


    <!-- No groups -->
    @if(empty($report['by_groups']))
        <div class="px-6">
            <x-admin.card class="p-6">
                <span class="text-sm text-[var(--color-text-light)]">No session groups found.</span>
            </x-admin.card>
        </div>
    @endif

</div>
