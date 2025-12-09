<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Feedback Forms', 'href' => route('admin.events.feedback-form.index', $event->id)],
        ['label' => $feedback_form->title],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Manage Feedback Form"
        subtitle="{{ $feedback_form->title }}">

        <div class="flex items-center gap-3">

            <x-admin.outline-btn-icon
                icon="heroicon-o-chart-bar"
                :href="route('admin.events.reports.feedback.view', [
                    'event' => $event->id,
                    'feedback_form' => $feedback_form->id
                ])">
                View report
            </x-admin.outline-btn-icon>

            <x-admin.outline-btn-icon
                icon="heroicon-o-arrow-down-tray"
                :href="route('admin.events.reports.feedback.pdf.export', [
                    'event' => $event->id,
                    'feedback_form' => $feedback_form->id
                ])">
                Download PDF
            </x-admin.outline-btn-icon>

            <x-admin.outline-btn-icon
                icon="heroicon-o-eye"
                :href="route('admin.events.feedback-form.preview.index', [
                    'event' => $event->id,
                    'feedback_form' => $feedback_form->id
                ])">
                Preview form
            </x-admin.outline-btn-icon>
        </div>

    </x-admin.page-header>

    <!-- Alerts -->
    @if (session('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Status Card -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-3">
            <x-admin.section-title title="Information" />

            <div class="flex items-center gap-4">

                <!-- Active -->
                @if($feedback_form->active)
                <x-admin.status-pill status="success">Active</x-admin.status-pill>
                @else
                <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                @endif

                <!-- Anonymous -->
                @if($feedback_form->is_anonymous)
                <x-admin.status-pill status="neutral">Anonymous</x-admin.status-pill>
                @endif

                <!-- Multi-step -->
                @if($feedback_form->multi_step)
                <x-admin.status-pill status="neutral">Multi-step</x-admin.status-pill>
                @endif

            </div>

        </x-admin.card>
    </div>



    <!-- Steps Section -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Steps" />

                <x-admin.outline-btn-icon
                    icon="heroicon-o-plus"
                    :href="route('admin.events.feedback-form.steps.create', [
                        'event' => $event->id,
                        'feedback_form' => $feedback_form->id
                    ])">
                    Add Step
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 w-28">Display Order</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse($feedback_form->steps as $step)

                        <!-- Main Row -->
                        <tr
                            wire:key="step-row-{{ $step->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <!-- Up / Down Arrows -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['steps'][$step->id] ?? $step->order"
                                    :id="$step->id"
                                    method="updateStepOrder"
                                    group="steps" />
                            </td>

                            <!-- Title -->
                            <td class="px-4 py-3 font-medium">
                                {{ $step->title }}
                            </td>

                            <!-- Order Input + Enter -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.steps.{{ $step->id }}"
                                        wire:keydown.enter="updateStepOrder({{ $step->id }})"
                                        class="rounded-sm text-xs" />

                                    <x-admin.table-order-input-enter
                                        :id="$step->id"
                                        method="updateStepOrder" />
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.feedback-form.steps.edit', [
                                'event' => $event->id,
                                'feedback_form' => $feedback_form->id,
                                'step' => $step->id
                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <x-admin.table-actions-toggle :row-id="$step->id" />
                                </div>
                            </td>

                        </tr>

                        <!-- Expanded Row -->
                        <tr
                            wire:key="step-row-expanded-{{ $step->id }}"
                            x-cloak
                            x-show="openRow === {{ $step->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="4" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.feedback-form.steps.edit', [
                                'event' => $event->id,
                                'feedback_form' => $feedback_form->id,
                                'step' => $step->id
                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    @if(!$step->groups()->exists())
                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteStep({{ $step->id }})"
                                        confirm="Delete this step?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true" />
                                    @else
                                    <span class="text-xs text-[var(--color-text-light)]">
                                        This step cannot be deleted as it contains question groups
                                    </span>
                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No steps found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>


        </x-admin.card>
    </div>



    <!-- Groups Section -->
    <div class="px-6">
        <x-admin.card class="p-6 space-y-6">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Groups" />

                <x-admin.outline-btn-icon
                    icon="heroicon-o-plus"
                    :href="route('admin.events.feedback-form.groups.create', [
                        'event' => $event->id,
                        'feedback_form' => $feedback_form->id
                    ])">
                    Add Group
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Step</th>
                            <th class="px-4 py-3 w-28">Display Order</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse($feedback_form->groups as $group)

                        <!-- Main Row -->
                        <tr
                            wire:key="group-row-{{ $group->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <!-- Up/Down Arrows -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['groups'][$group->id] ?? $group->order"
                                    :id="$group->id"
                                    method="updateGroupOrder"
                                    group="groups" />
                            </td>

                            <!-- Title -->
                            <td class="px-4 py-3 font-medium">
                                {{ $group->title }}
                            </td>

                            <!-- Step -->
                            <td class="px-4 py-3">
                                {{ $group->step->title }}
                            </td>

                            <!-- Order Input + Enter -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.groups.{{ $group->id }}"
                                        wire:keydown.enter="updateGroupOrder({{ $group->id }})"
                                        class="rounded-sm text-xs" />

                                    <x-admin.table-order-input-enter
                                        :id="$group->id"
                                        method="updateGroupOrder" />
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.feedback-form.groups.edit', [
                                'event' => $event->id,
                                'feedback_form' => $feedback_form->id,
                                'group' => $group->id
                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.feedback-form.questions.manage', [
                                'event' => $event->id,
                                'feedback_form' => $feedback_form->id,
                                'group' => $group->id
                            ])"
                                        icon="bars-3-bottom-left"
                                        label="Questions" />

                                    <x-admin.table-actions-toggle :row-id="$group->id" />

                                </div>
                            </td>

                        </tr>

                        <!-- Expanded Row -->
                        <tr
                            wire:key="group-row-expanded-{{ $group->id }}"
                            x-cloak
                            x-show="openRow === {{ $group->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="5" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.feedback-form.groups.edit', [
                                'event' => $event->id,
                                'feedback_form' => $feedback_form->id,
                                'group' => $group->id
                            ])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    @if(!$group->questions()->exists())
                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteGroup({{ $group->id }})"
                                        confirm="Delete this group?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true" />
                                    @else
                                    <span class="text-xs text-[var(--color-text-light)]">
                                        This group cannot be deleted as it contains questions
                                    </span>
                                    @endif

                                </div>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No groups found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>


        </x-admin.card>
    </div>

</div>