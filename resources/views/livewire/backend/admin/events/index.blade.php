<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Events</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage and organise all platform events.
            </p>
        </div>

        <!-- Right side: Add Event -->
        <div class="flex items-center gap-3">

            <a href="{{ route('admin.events.create') }}"
               class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                      bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                      text-[var(--color-primary)]
                      hover:bg-[var(--color-primary)] hover:text-white
                      transition-colors duration-150">
                <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                <span class="hidden md:inline">Create event</span>
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
        <x-admin.section-title title="Events" />
        
        <!-- Filters row -->
        <div class="flex flex-wrap items-center gap-2 mb-2">

            <x-admin.filter-pill
                :active="$filter === 'all'"
                wire:click="setFilter('all')"
            >
                All
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'active'"
                wire:click="setFilter('active')"
            >
                Active
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'inactive'"
                wire:click="setFilter('inactive')"
            >
                Inactive
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'template'"
                wire:click="setFilter('template')"
            >
                Templates
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'archived'"
                wire:click="setFilter('archived')"
            >
                Archived
            </x-admin.filter-pill>
        </div>

        <!-- Search -->
        <div class="mb-2">
            <div class="relative">
                <x-heroicon-o-magnifying-glass
                    class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search event title or location"
                    class="w-full pl-10 pr-3 py-2 text-sm rounded-lg
                           bg-[var(--color-surface)] border border-[var(--color-border)]
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20
                           outline-none transition"
                />
            </div>
        </div>

        <!-- Table overflow container with fade -->
        <div class="relative">

            <!-- Scroll fade (right) -->
            <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                        bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($events as $event)

                            <!-- ======================= -->
                            <!-- MAIN TABLE ROW          -->
                            <!-- ======================= -->
                            <tr x-data
                                class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Title -->
                                <td class="px-4 py-3">
                                    {{ $event->title }} 
                                    @if($event->template)
                                        <x-admin.status-pill status="info">
                                            Template
                                        </x-admin.status-pill>
                                    @endif
                                </td>

                                <!-- Status Pill -->
                                <td class="px-4 py-3">
                                    @if ($event->active)
                                        <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                    @else
                                        <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                    @endif
                                </td>

                                <!-- Actions Button -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.manage', $event->id)"
                                            icon="arrow-right-circle"
                                            label="Manage"
                                        />

                                        <x-admin.table-actions-toggle :row-id="$event->id" />

                                    </div>
                                </td>

                            </tr>

                            <!-- ======================= -->
                            <!-- EXPANDED ACTION BAR     -->
                            <!-- ======================= -->
                            <tr x-cloak
                                x-show="openRow === {{ $event->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="3" class="px-4 py-4">

                                    <div class="flex flex-wrap items-center justify-end gap-3">
                                        <x-admin.table-action-button
                                            type="button"
                                            wireClick="duplicate({{ $event->id }})"
                                            confirm="Copy this event?"
                                            icon="document-duplicate"
                                            label="Copy"
                                        />

                                        @if (! $event->template)
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="delete({{ $event->id }})"
                                                confirm="Soft delete this event?"
                                                icon="trash"
                                                label="Delete"
                                                danger="true"
                                            />
                                        @endif

                                    </div>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No events found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>



        <div>

        <div class="mt-4 flex items-center justify-between">
            <div class="text-xs text-[var(--color-text-light)] ms-4">
            Showing {{ $events->firstItem() }}–{{ $events->lastItem() }} of {{ $events->total() }}
            </div>

            <!-- Livewire reactive pagination -->
            <div class="flex items-center gap-2">
            @if ($events->onFirstPage())
                <button disabled class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs bg-[var(--color-surface)] border border-[var(--color-border)] text-[var(--color-text-light)] opacity-60 cursor-not-allowed">
                <x-heroicon-o-chevron-left class="w-4 h-4" />
                </button>
            @else
                <button wire:click="previousPage" class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition">
                <x-heroicon-o-chevron-left class="w-4 h-4" />
                </button>
            @endif

            @if ($events->hasMorePages())
                <button wire:click="nextPage" class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white transition">
                <x-heroicon-o-chevron-right class="w-4 h-4" />
                </button>
            @else
                <button disabled class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs bg-[var(--color-surface)] border border-[var(--color-border)] text-[var(--color-text-light)] opacity-60 cursor-not-allowed">
                <x-heroicon-o-chevron-right class="w-4 h-4" />
                </button>
            @endif
            </div>
        </div>
        </div>



    </div>

</div>
