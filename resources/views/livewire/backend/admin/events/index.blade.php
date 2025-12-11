<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Events"
        subtitle="Manage and organise all platform events.">
        <x-admin.outline-btn-icon
            :href="route('admin.events.create')"
            icon="heroicon-o-plus"
            soft>
            Create event
        </x-admin.outline-btn-icon>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main card -->
    <x-admin.card hover="false" class="p-6 mx-6 space-y-4">

        <!-- Filters row -->
        <div class="flex flex-wrap items-center gap-2 mb-2">

            <x-admin.filter-pill
                :active="$filter === 'all'"
                wire:click="setFilter('all')">
                All ({{ $counts['all'] }})
            </x-admin.filter-pill>


            <x-admin.filter-pill
                :active="$filter === 'active'"
                wire:click="setFilter('active')">
                Active ({{ $counts['active'] }})
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'inactive'"
                wire:click="setFilter('inactive')">
                Inactive ({{ $counts['inactive'] }})
            </x-admin.filter-pill>

            <x-admin.filter-pill
                :active="$filter === 'template'"
                wire:click="setFilter('template')">
                Templates ({{ $counts['template'] }})
            </x-admin.filter-pill>

            <!-- <x-admin.filter-pill
                :active="$filter === 'archived'"
                wire:click="setFilter('archived')">
                Archived ({{ $counts['archived'] }})
            </x-admin.filter-pill> -->

        </div>

        <!-- Search -->
        <x-admin.search-input
            wire:model.live.debounce.300ms="search"
            placeholder="Search event title or location" />


        <!-- Table -->
        <x-admin.table>
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-[var(--color-text-light)] font-light uppercase text-xs border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                    @forelse($events as $event)

                    <!-- Main table row -->
                    <tr x-data
                        class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                        <!-- Title -->
                        <td class="px-4 py-3">
                            {{ $event->title }}
                            @if($event->template)
                            <br>
                            <p class="text-xs text-[var(--color-text)]/40">
                                Template
                            </p>
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
                                    primary
                                    label="Manage" />

                                <x-admin.table-actions-toggle :row-id="$event->id" />
                            </div>
                        </td>
                    </tr>

                    <!-- Expanded action bar -->
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
                                    label="Copy" />

                                @if (! $event->template)
                                <x-admin.table-action-button
                                    type="button"
                                    wireClick="delete({{ $event->id }})"
                                    confirm="Soft delete this event?"
                                    icon="trash"
                                    label="Delete"
                                    danger="true" />
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
        </x-admin.table>

        <!-- Pagination -->
        <x-admin.pagination :paginator="$events" />

    </x-admin.card>

</div>