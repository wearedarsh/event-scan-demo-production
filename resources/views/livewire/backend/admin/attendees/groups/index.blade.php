<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendee Groups'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Attendee Groups</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage attendee segmentation, colours, and group assignments.
            </p>
        </div>

        <!-- Add Group Button -->
        <a href="{{ route('admin.events.attendees.groups.create', $event->id) }}"
           class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)]
                  hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
            <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
            <span class="hidden md:inline">Add group</span>
        </a>

    </div>


    <!-- Alerts -->
    @if ($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif


    <!-- ============================================================= -->
    <!-- MAIN CARD -->
    <!-- ============================================================= -->
    <div class="soft-card p-6 mx-6 space-y-4">

        <!-- Section Title -->
        <x-admin.section-title title="Attendee groups" />

        <!-- Search -->
        <div class="mb-2">
            <div class="relative">
                <x-heroicon-o-magnifying-glass
                    class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search group name"
                    class="w-full pl-10 pr-3 py-2 text-sm rounded-lg
                           bg-[var(--color-surface)] border border-[var(--color-border)]
                           focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20
                           outline-none transition"
                />
            </div>
        </div>


        <!-- Table Wrapper -->
        <div class="relative">

            <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                        bg-gradient-to-l from-[var(--color-surface)] to-transparent">
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Group Name</th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($attendee_groups as $group)
                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Name -->
                                <td class="px-4 py-3 font-medium">
                                    {{ $group->title }}
                                </td>

                                <!-- Label colour chip -->
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
                                    <div class="inline-flex items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.attendees.groups.edit', [
                                                'event' => $event->id,
                                                'attendee_group' => $group->id
                                            ])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                        @if ($group->attendees->count() === 0)
                                            <x-admin.table-action-button
                                                type="button"
                                                danger="true"
                                                wireClick="deleteAttendeeGroup({{ $group->id }})"
                                                confirm="Delete this group?"
                                                icon="trash"
                                                label="Delete"
                                            />
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
            </div>

        </div>

        <!-- Pagination -->
        <div class="pt-2">
            {{ $attendee_groups->links('pagination::tailwind') }}
        </div>

    </div>

</div>
