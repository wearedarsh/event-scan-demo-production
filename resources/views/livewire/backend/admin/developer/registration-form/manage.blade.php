<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Registration Forms', 'href' => route('admin.developer.registration-form.index')],
        ['label' => $form->label],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Manage registration form"
        subtitle="{{ $form->label }} ({{ $form->type }})">
        <x-admin.outline-btn-icon
            :href="route('admin.developer.registration-form.steps.create', $form->id)"
            icon="heroicon-o-plus">
            Add Step
        </x-admin.outline-btn-icon>
    </x-admin.page-header>

    <!-- Alerts -->
    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- Steps -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <x-admin.section-title title="Steps" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse ($steps as $step)

                            <tr
                                wire:key="step-row-{{ $step->id }}"
                                class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                                <!-- Up / Down -->
                                <td class="px-2 py-3">
                                    <x-admin.table-order-up-down
                                        :order="$orders[$step->id]"
                                        :id="$step->id"
                                        upMethod="moveStepUp"
                                        downMethod="moveStepDown" />
                                </td>

                                <!-- Label -->
                                <td class="px-4 py-3 font-medium">
                                    {{ $step->label }}
                                </td>

                                <!-- Type -->
                                <td class="px-4 py-3">
                                    @if ($step->type === 'rigid')
                                        <x-admin.status-pill status="info">Rigid</x-admin.status-pill>
                                    @else
                                        <x-admin.status-pill status="success">Dynamic</x-admin.status-pill>
                                    @endif
                                </td>

                                <!-- Order -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <x-admin.table-order-input
                                            wire:model.defer="orders.{{ $step->id }}"
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
                                        @if ($step->type === 'dynamic')
                                            <x-admin.table-action-button
                                                type="link"
                                                :href="route('admin.developer.registration-form.steps.manage', ['step' => $step->id])"
                                                icon="arrow-right-circle"
                                                primary
                                                label="Manage" />
                                        @endif

                                        <x-admin.table-actions-toggle :row-id="$step->id" />
                                    </div>
                                </td>
                            </tr>

                            <!-- Expanded row -->
                            <tr
                                wire:key="step-row-expanded-{{ $step->id }}"
                                x-cloak
                                x-show="openRow === {{ $step->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="6" class="px-4 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-3">

                                            <x-admin.table-action-button
                                                type="button"
                                                danger="true"
                                                confirm="Delete this step?"
                                                wireClick="deleteStep({{ $step->id }})"
                                                icon="trash"
                                                label="Delete" />

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No steps found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>

    </div>

</div>
