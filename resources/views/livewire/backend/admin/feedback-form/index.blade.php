<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Feedback Forms'],
    ]" />


    <!-- Page Header -->
    <x-admin.page-header
        title="Feedback forms"
        subtitle="Manage all feedback forms for this event."
    />


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Communication Block -->
    <div class="px-6">
        <x-admin.section-title title="Communication" />
        <x-admin.card class="p-5 space-y-4">

            

            <x-admin.outline-btn-icon
                :href="route('admin.events.emails.send-email', [
                    'event' => $event->id,
                    'audience' => 'attendees_incomplete_feedback',
                    'lock' => 1
                ])"
                icon="heroicon-o-envelope"
            >
                Send email reminder
            </x-admin.outline-btn-icon>

        </x-admin.card>
    </div>


    <!-- Feedback Forms Table -->
    <div class="px-6 space-y-4">
        
        <x-admin.section-title title="Feedback Forms" />

        <x-admin.card class="p-5 space-y-4">

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                    <tr class="text-xs uppercase text-[var(--color-text-light)]
                               border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 w-32 text-right">Actions</th>
                    </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                    @forelse($event->feedbackFormsAll as $form)

                        <!-- Row -->
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

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Quick link: View results -->
                                    <x-admin.table-action-button
                                        type="link"
                                        icon="chart-bar"
                                        label="Manage"
                                        :href="route('admin.events.feedback-form.manage', [
                                            'event' => $event->id,
                                            'feedback_form' => $form->id
                                        ])"
                                    />

                                    <!-- Toggle for expanded actions -->
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
                            <td colspan="3" class="px-4 py-4">

                                <div class="flex flex-wrap justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="link"
                                        icon="eye"
                                        label="Preview"
                                        :href="route('admin.events.feedback-form.preview.index', [
                                            $event->id,
                                            $form->id
                                        ])"
                                    />

                                    <x-admin.table-action-button
                                        type="link"
                                        icon="document-arrow-down"
                                        label="Download report"
                                        :href="route('admin.events.reports.feedback.pdf.export', [
                                            $event->id,
                                            $form->id
                                        ])"
                                    />

                                    <x-admin.table-action-button
                                        type="link"
                                        icon="chart-bar"
                                        label="View report"
                                        :href="route('admin.events.reports.feedback.view', [
                                            'event' => $event->id,
                                            'feedback_form' => $form->id
                                        ])"
                                    />

                                    <x-admin.table-action-button
                                        type="link"
                                        icon="pencil-square"
                                        label="Edit"
                                        :href="route('admin.events.feedback-form.edit', [
                                            $event->id,
                                            $form->id
                                        ])"
                                    />

                                </div>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3"
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
