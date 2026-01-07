<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Registration Forms', 'href' => route('admin.developer.registration-form.index')],
        ['label' => $step->label],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Manage step fields"
        subtitle="{{ $step->label }}">
        <x-admin.outline-btn-icon
            :href="route('admin.developer.registration-form.fields.create', $step->id)"
            icon="heroicon-o-plus">
            Add Field
        </x-admin.outline-btn-icon>
    </x-admin.page-header>

    <!-- Alerts -->
    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <x-admin.section-title title="Fields" />

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

                        @forelse ($inputs as $input)

                            <tr
                                wire:key="input-row-{{ $input->id }}"
                                class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                                <!-- Up / Down -->
                                <td class="px-2 py-3">
                                    <x-admin.table-order-up-down
                                        :order="$orders[$input->id]"
                                        :id="$input->id"
                                        upMethod="moveInputUp"
                                        downMethod="moveInputDown" />
                                </td>

                                <!-- Label -->
                                <td class="px-4 py-3 font-medium">
                                    {{ $input->label }}
                                </td>

                                <!-- Type -->
                                <td class="px-4 py-3 text-xs text-[var(--color-text-light)]">
                                    {{ $input->type }}
                                </td>

                                <!-- Order -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <x-admin.table-order-input
                                            wire:model.defer="orders.{{ $input->id }}"
                                            wire:keydown.enter="updateInputOrder({{ $input->id }})"
                                            class="rounded-sm text-xs" />

                                        <x-admin.table-order-input-enter
                                            :id="$input->id"
                                            method="updateInputOrder" />
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('home')"
                                            icon="pencil-square"
                                            primary
                                            label="Edit" />

                                        <x-admin.table-actions-toggle :row-id="$input->id" />
                                    </div>
                                </td>
                            </tr>

                            <!-- Expanded row -->
                            <tr
                                wire:key="input-row-expanded-{{ $input->id }}"
                                x-cloak
                                x-show="openRow === {{ $input->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="5" class="px-4 py-4">
                                    <div class="flex justify-end gap-3">
                                        <x-admin.table-action-button
                                            type="button"
                                            danger="true"
                                            confirm="Delete this field?"
                                            wireClick="deleteInput({{ $input->id }})"
                                            icon="trash"
                                            label="Delete" />
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No fields found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>

    </div>

</div>
