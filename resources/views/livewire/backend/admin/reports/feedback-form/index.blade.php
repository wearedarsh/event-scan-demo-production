<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Reports', 'href' => route('admin.events.reports.index', $event->id)],
        ['label' => 'Feedback Forms'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Feedback forms"
        subtitle="View summary results for all event feedback forms."
    />


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Table Section -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Feedback Forms" />

        <x-admin.card class="p-5 space-y-4">

            <!-- Header Actions -->
            <div class="flex items-center justify-between">
                <h3 class="font-medium">All Feedback Forms</h3>

                {{-- Future: Export form list or add new form during setup --}}
            </div>


            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)]
                                   border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Questions</th>
                            <th class="px-4 py-3 text-right w-32">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($feedback_forms as $form)

                        <!-- Main Row -->
                        <tr
                            class="border-b border-[var(--color-border)]
                                   hover:bg-[var(--color-surface-hover)] transition">

                            <!-- Title -->
                            <td class="px-4 py-3 font-medium">
                                {{ $form->title }}
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                @if($form->active)
                                    <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                    <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <!-- Question count -->
                            <td class="px-4 py-3">
                                {{ $form->questions_count }}
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- View Results -->
                                    <x-admin.table-action-button
                                        type="link"
                                        icon="chart-bar"
                                        label="View results"
                                        :href="route('admin.events.reports.feedback.view', [
                                            'event' => $event->id,
                                            'feedback_form' => $form->id
                                        ])"
                                    />

                                    <!-- Toggle Dropdown -->
                                    <x-admin.table-actions-toggle :row-id="$form->id" />
                                </div>
                            </td>
                        </tr>


                        <!-- Expanded Action Row -->
                        <tr x-cloak
                            x-show="openRow === {{ $form->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)]
                                   border-b border-[var(--color-border)]">
                            <td colspan="4" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    {{-- In future: Duplicate form, Export responses, Archive? --}}
                                    <x-admin.table-action-button
                                        type="link"
                                        icon="eye"
                                        label="View results"
                                        :href="route('admin.events.reports.feedback.view', [
                                            'event' => $event->id,
                                            'feedback_form' => $form->id
                                        ])"
                                    />

                                </div>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="4"
                                class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No feedback forms found for this event.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>

    </div>

</div>
