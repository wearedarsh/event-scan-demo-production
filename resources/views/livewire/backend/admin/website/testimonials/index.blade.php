<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Website', 'href' => route('admin.website.index')],
        ['label' => 'Testimonials'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Testimonials"
        subtitle="Manage all website testimonials."
    >
<x-admin.outline-btn-icon
                    :href="route('admin.website.testimonials.create')"
                    icon="heroicon-o-plus">
                    Add testimonial
                </x-admin.outline-btn-icon>
    </x-admin.page-header>

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main Section -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <!-- Table -->
            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($testimonials as $t)

                        <!-- MAIN ROW -->
                        <tr
                            wire:key="testimonial-row-{{ $t->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]"
                        >

                            <!-- Up/Down Order Buttons (matches session groups) -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders[$t->id]"
                                    :id="$t->id"
                                    moveUp="moveUp"
                                    moveDown="moveDown"
                                />
                            </td>

                            <!-- Title -->
                            <td class="px-4 py-3 font-medium">
                                {{ $t->title }}
                            </td>

                            <!-- Order Input -->
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.{{ $t->id }}"
                                        wire:keydown.enter="updateOrder({{ $t->id }})"
                                        class="rounded-sm text-xs"
                                    />

                                    <x-admin.table-order-input-enter
                                        :id="$t->id"
                                        method="updateOrder"
                                    />
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                @if ($t->active)
                                    <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                    <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.website.testimonials.edit', $t->id)"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <!-- Toggle row -->
                                    <x-admin.table-actions-toggle :row-id="$t->id" />

                                </div>
                            </td>

                        </tr>


                        <!-- EXPANDED ROW -->
                        <tr
                            wire:key="testimonial-row-expanded-{{ $t->id }}"
                            x-cloak
                            x-show="openRow === {{ $t->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]"
                        >
                            <td colspan="5" class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="delete({{ $t->id }})"
                                        confirm="Delete this testimonial?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true"
                                    />

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No testimonials found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>


            <!-- Pagination (if using paginate instead of get()) -->
            @if(method_exists($testimonials, 'links'))
                <x-admin.pagination :paginator="$testimonials" />
            @endif

        </x-admin.card>

    </div>

</div>
