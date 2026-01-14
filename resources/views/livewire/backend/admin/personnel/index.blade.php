<div class="space-y-4">

    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Personnel'],
    ]" />

    <x-admin.page-header
        title="Personnel"
        subtitle="Manage personnel groups and individual personnel.">
        <x-admin.stat-card
            label="Total personnel"
            :value="$personnel->total()" />
    </x-admin.page-header>

    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <div class="px-6">
        <x-admin.action-card
            title="Badges"
            icon="heroicon-o-identification"
            description="Export print-ready personnel badges.">
            <x-link-arrow href="{{ route('admin.events.personnel.badges.export', $event->id) }}">
                Print badges
            </x-link-arrow>
        </x-admin.action-card>
    </div>


    <div class="px-6 space-y-4">

        <x-admin.section-title title="Personnel groups" />

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">

                <!-- Add Group -->
                <x-admin.outline-btn-icon
                    :href="route('admin.events.personnel.groups.create', $event->id)"
                    icon="heroicon-o-plus">
                    Add group
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Group</th>
                            <th class="px-4 py-3">Label</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($this->personnelGroups as $group)

                        <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3">{{ $group->title }}</td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs font-medium shadow-sm"
                                    style="background: {{ $group->label_background_colour }};
                                               color: {{ $group->label_colour }};">
                                    {{ $group->title }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.personnel.groups.edit', [$event->id, $group->id])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    @if($group->personnel->count() === 0)
                                    <x-admin.table-action-button
                                        type="button"
                                        danger="true"
                                        confirm="Delete this group?"
                                        wireClick="deletePersonnelGroup({{ $group->id }})"
                                        icon="trash"
                                        label="Delete" />
                                    @else
                                    <span class="text-xs text-[var(--color-text-light)]">In use</span>
                                    @endif

                                </div>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No groups found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

        </x-admin.card>

    </div>



    <!-- Personnel List -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Personnel" />

        <x-admin.card class="p-5 space-y-4">

            <!-- Filters -->
            <div class="grid sm:grid-cols-3 gap-4">

                <x-admin.search-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search name or group" />

                <x-admin.select wire:model.live="group_filter">
                    <option value="">All Groups</option>
                    @foreach($this->personnelGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                    @endforeach
                </x-admin.select>

                <!-- Personel -->
                <div class="flex justify-end">
                    <x-admin.outline-btn-icon
                        :href="route('admin.events.personnel.create', $event->id)"
                        icon="heroicon-o-plus">
                        Add personnel
                    </x-admin.outline-btn-icon>
                </div>
            </div>


            <!-- Table -->
            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Line 1</th>
                            <th class="px-4 py-3">Line 2</th>
                            <th class="px-4 py-3">Line 3</th>
                            <th class="px-4 py-3">Group</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($personnel as $person)

                        <!-- Main row -->
                        <tr x-data
                            class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3">{{ $person->line_1 }}</td>
                            <td class="px-4 py-3">{{ $person->line_2 }}</td>
                            <td class="px-4 py-3">{{ $person->line_3 }}</td>

                            <td class="px-4 py-3">
                                @if($person->group)
                                <span class="px-2 py-1 rounded text-xs font-medium shadow-sm"
                                    style="background: {{ $person->group->label_background_colour }};
                                   color: {{ $person->group->label_colour }};">
                                    {{ $person->group->title }}
                                </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <!-- Edit (primary) -->
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.personnel.edit', [$event->id, $person->id])"
                                        icon="pencil-square"
                                        label="Edit" />

                                    <!-- Toggle -->
                                    <x-admin.table-actions-toggle :row-id="$person->id" />

                                </div>
                            </td>
                        </tr>

                        <!-- Expanded action bar -->
                        <tr x-cloak
                            x-show="openRow === {{ $person->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="5" class="px-4 py-4">

                                <div class="flex flex-wrap items-center justify-end gap-3">

                                    <!-- Print label -->
                                    <x-admin.table-action-button
                                        type="button"
                                        icon="printer"
                                        label="Label"
                                        wireClick="openLabelModal({{ $person->id }})" />

                                    <!-- Delete -->
                                    <x-admin.table-action-button
                                        type="button"
                                        danger="true"
                                        confirm="Delete this personnel?"
                                        wireClick="delete({{ $person->id }})"
                                        icon="trash"
                                        label="Delete" />

                                </div>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No personnel found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </x-admin.table>



            <!-- Pagination -->
            <x-admin.pagination :paginator="$personnel" />

        </x-admin.card>

    </div>
    @include('livewire.backend.admin.personnel.modals.label-modal')
</div>