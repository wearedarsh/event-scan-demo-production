<div class="space-y-6">

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
    </x-admin.page-header>


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main Table Section -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Testimonials" />

        <x-admin.card class="p-5 space-y-4">

            <!-- Header Actions -->
            <div class="flex items-center justify-between">

                <h3 class="font-medium">All Testimonials</h3>

                <x-admin.outline-btn-icon
                    :href="route('admin.website.testimonials.create')"
                    icon="heroicon-o-plus">
                    Add testimonial
                </x-admin.outline-btn-icon>

            </div>


            <!-- Table -->
            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 w-24">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($testimonials as $t)

                        <!-- Main Row -->
                        <tr x-data class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <!-- Title -->
                            <td class="px-4 py-3">
                                {{ $t->title }}
                            </td>

                            <!-- Order Input -->
                            <td class="px-4 py-3 w-20">
                                <x-admin.input-text
                                    class="w-20 text-center p-1"
                                    wire:model.lazy="orders.{{ $t->id }}"
                                    wire:change="updateOrder({{ $t->id }}, $event.target.value)"
                                />
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

                                    <!-- Edit -->
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.website.testimonials.edit', $t->id)"
                                        icon="pencil-square"
                                        label="Edit"
                                    />

                                    <!-- Toggle -->
                                    <x-admin.table-actions-toggle :row-id="$t->id" />

                                </div>
                            </td>
                        </tr>


                        <!-- Expanded Action Row -->
                        <tr x-cloak
                            x-show="openRow === {{ $t->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="4" class="px-4 py-4">

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
                            <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No testimonials found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>


            <!-- Pagination -->
            @if(method_exists($testimonials, 'links'))
                <x-admin.pagination :paginator="$testimonials" />
            @endif

        </x-admin.card>

    </div>

</div>
