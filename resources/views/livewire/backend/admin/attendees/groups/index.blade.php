<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendee Groups'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Attendee Groups"
        subtitle="Manage attendee segmentation, colours, and group assignments.">
        <x-admin.outline-btn-icon
            :href="route('admin.events.attendees.groups.create', $event->id)"
            icon="heroicon-o-plus"
            soft>
            Create group
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

        <!-- Section Title -->
        <x-admin.section-title title="Attendee groups" />

        <!-- Search -->
        <x-admin.search-input
            wire:model.live.debounce.300ms="search"
            placeholder="Search group name" />


        <!-- Table -->
        <x-admin.table>
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-[var(--color-text-light)] font-light uppercase text-xs border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Label</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                @forelse($attendee_groups as $group)

                    <!-- Main Row -->
                    <tr
                        x-data
                        @click="openRow = openRow === {{ $group->id }} ? null : {{ $group->id }}"
                        class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition cursor-pointer">

                        <!-- Title -->
                        <td class="px-4 py-3 font-medium">
                            {{ $group->title }}
                        </td>

                        <!-- Colour Label -->
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded text-xs font-medium shadow-sm"
                                style="
                                    background-color: {{ $group->colour ?? '#6b7280' }};
                                    color: {{ $group->label_colour ?? '#fff' }};
                                ">
                                {{ $group->title }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end items-center gap-2">

                                <x-admin.table-action-button
                                    type="link"
                                    primary
                                    :href="route('admin.events.attendees.groups.edit', [
                                        'event' => $event->id,
                                        'attendee_group' => $group->id
                                    ])"
                                    icon="pencil-square"
                                    label="Edit" />

                                <x-admin.table-actions-toggle :row-id="$group->id" />

                            </div>
                        </td>
                    </tr>

                    <!-- Expanded Action Row -->
                    <tr x-cloak x-show="openRow === {{ $group->id }}"
                        x-transition.duration.150ms
                        class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                        <td colspan="3" class="px-4 py-4">

                            <div class="flex flex-wrap items-center justify-end gap-3">

                                @if ($group->attendees->count() === 0)
                                <x-admin.table-action-button
                                    type="button"
                                    danger="true"
                                    wireClick="deleteAttendeeGroup({{ $group->id }})"
                                    confirm="Delete this group?"
                                    icon="trash"
                                    label="Delete" />
                                @else
                                    <span class="text-xs text-[var(--color-text-light)]">
                                        This group cannot be deleted as it contains attendees
                                    </span>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                            No attendee groups found.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </x-admin.table>

        <!-- Pagination -->
        <x-admin.pagination :paginator="$attendee_groups" />

    </x-admin.card>

</div>
