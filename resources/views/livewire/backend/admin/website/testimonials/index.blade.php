<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Website', 'href' => route('admin.website.index')],
        ['label' => 'Testimonials'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Testimonials</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage all website testimonials.
            </p>
        </div>

        <!-- Right side: Add Testimonial -->
        <div class="flex items-center gap-3">

            <a href="{{ route('admin.website.testimonials.create') }}"
                class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                      bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                      text-[var(--color-primary)]
                      hover:bg-[var(--color-primary)] hover:text-white
                      transition-colors duration-150">
                <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                <span class="hidden md:inline">Create testimonial</span>
            </a>

        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
    <div class="px-6">
        <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
            <p class="text-sm text-[var(--color-warning)] font-medium">
                {{ $errors->first() }}
            </p>
        </div>
    </div>
    @endif

    @if (session()->has('success'))
    <div class="px-6">
        <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
            <p class="text-sm text-[var(--color-success)] font-medium">
                {{ session('success') }}
            </p>
        </div>
    </div>
    @endif

    <!-- Main card -->
    <div class="soft-card p-6 mx-6 space-y-4">

        <!-- Section title -->
        <x-admin.section-title title="Testimonials" />

        <!-- Table Container -->
        <div class="relative">

            <!-- Scroll Fade -->
            <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($testimonials as $t)

                        <!-- Main Row -->
                        <tr x-data
                            class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <!-- Title -->
                            <td class="px-4 py-3">
                                {{ $t->title }}
                            </td>

                            <!-- Order -->
                            <td class="px-4 py-3 w-20">
                                <input type="text"
                                    class="w-16 input-text p-1 text-center"
                                    wire:model.lazy="orders.{{ $t->id }}"
                                    wire:change="updateOrder({{ $t->id }}, $event.target.value)" />
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

                                    <x-admin.table-actions-toggle :row-id="$t->id" />

                                </div>
                            </td>
                        </tr>

                        <!-- Expanded Action Bar -->
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
                                        danger="true" />

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="4"
                                class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No testimonials found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>


        <!-- Pagination (optional if using paginate()) -->
        @if(method_exists($testimonials, 'links'))
        <div class="mt-4 flex items-center justify-between">
            <div class="text-xs text-[var(--color-text-light)] ms-4">
                Showing {{ $testimonials->firstItem() }}–{{ $testimonials->lastItem() }} of {{ $testimonials->total() }}
            </div>

            <div>
                {{ $testimonials->links('pagination::tailwind') }}
            </div>
        </div>
        @endif

    </div>

</div>