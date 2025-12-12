<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Feedback'],
        ['label' => $report['form']['title'] ?? 'View']
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Feedback report"
        subtitle="{{ $report['form']['title'] }}"
    />

    <!-- Tools -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-4">

            <x-admin.section-title title="Tools" />

            <div class="flex flex-wrap items-center gap-3">

                <x-admin.outline-btn-icon
                    icon="heroicon-o-arrow-down-tray"
                    :href="route('admin.events.reports.feedback.pdf.export', [$event->id, $feedback_form->id])"
                >
                    Export PDF
                </x-admin.outline-btn-icon>

            </div>

        </x-admin.card>
    </div>

    <!-- Stats -->
    <div class="px-6">
        <x-admin.card class="p-6">

            <x-admin.section-title title="Overview" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <x-admin.stat-card
                    label="In Progress"
                    :value="$report['totals']['in_progress']"
                />

                <x-admin.stat-card
                    label="Completed"
                    :value="$report['totals']['complete']"
                />

                <x-admin.stat-card
                    label="Completion Rate"
                    :value="$report['totals']['completion_rate'] . '%'"
                />

            </div>

        </x-admin.card>
    </div>


    <!-- Groups + Questions -->
    <div class="px-6 space-y-6 pb-10">

        @forelse($report['groups'] as $group)

            <x-admin.card class="p-6 space-y-6">

                <x-admin.section-title :title="$group['title']" />

                @forelse($group['questions'] as $q)

                    <!-- Question Block -->
                    <div class="border border-[var(--color-border)] rounded-xl p-5 space-y-4">

                        <!-- Question header -->
                        <div>
                            <h4 class="font-semibold text-[var(--color-text)]">{{ $q['question'] }}</h4>
                            <div class="text-sm text-[var(--color-text-light)] mt-1">
                                Responses: <strong>{{ $q['total_answers'] }}</strong>
                            </div>
                        </div>

                        <!-- MULTIPLE CHOICE -->
                        @if(!empty($q['labels']))

                            <div class="grid md:grid-cols-2 gap-6">

                                <!-- Chart -->
                                <x-reports.chart-block
                                    id="chart-q-{{ $q['id'] }}"
                                    label=""
                                />

                                <!-- List of labels/counts/percentages -->
                                <x-reports.list
                                    :labels="$q['labels']"
                                    :counts="$q['counts']"
                                    :totals="$q['percentages']"
                                    type="percentage"
                                />

                            </div>

                        @else
                            <!-- OPEN TEXT / SAMPLES -->
                            @if(!empty($q['samples']))

                                <ul class="list-disc ml-6 space-y-1">
                                    @foreach($q['samples'] as $s)
                                        <li class="text-sm">{{ $s }}</li>
                                    @endforeach
                                </ul>

                            @else

                                <div class="text-sm text-[var(--color-text-light)]">
                                    No responses.
                                </div>

                            @endif
                        @endif

                    </div>

                @empty
                    <div class="text-sm text-[var(--color-text-light)]">No questions in this group.</div>
                @endforelse

            </x-admin.card>

        @empty
            <x-admin.card class="p-6">
                <div class="text-sm text-[var(--color-text-light)]">No feedback groups found.</div>
            </x-admin.card>
        @endforelse

    </div>

    <!-- Chart.js Rendering -->
    <x-reports.charts-js :charts="$charts" event="feedback-charts:update" />

</div>
