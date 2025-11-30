<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Team members'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Team members"
        subtitle="Manage staff accounts, roles and access."
    >
        <x-admin.button variant="outline" href="{{ route('admin.users.create') }}">
            <x-heroicon-o-plus class="h-4 w-4 mr-1" />
            Add team member
        </x-admin.button>
    </x-admin.page-header>

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- MAIN CONTENT -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <!-- Role Filter Pills -->
            <div class="flex flex-wrap items-center gap-2">

                <x-admin.filter-pill :active="$roleFilter === 'all'" wire:click="setRoleFilter('all')">
                    All
                </x-admin.filter-pill>

                <x-admin.filter-pill :active="$roleFilter === 'super_admin'" wire:click="setRoleFilter('super_admin')">
                    Super admin
                </x-admin.filter-pill>

                <x-admin.filter-pill :active="$roleFilter === 'admin'" wire:click="setRoleFilter('admin')">
                    Admin
                </x-admin.filter-pill>

                <x-admin.filter-pill :active="$roleFilter === 'app_user'" wire:click="setRoleFilter('app_user')">
                    App user
                </x-admin.filter-pill>

                <x-admin.filter-pill :active="$roleFilter === 'developer'" wire:click="setRoleFilter('developer')">
                    Developer
                </x-admin.filter-pill>

            </div>

            <!-- Search -->
            <div class="max-w-md mt-1">
                <x-admin.search-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search name or email..."
                />
            </div>

            <!-- Table -->
            <x-admin.table>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="uppercase text-xs text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($users as $user)
                            <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Name -->
                                <td class="px-4 py-3">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </td>

                                <td class="px-4 py-3">{{ $user->email }}</td>

                                <td class="px-4 py-3">{{ $user->role->name }}</td>

                                <td class="px-4 py-3">
                                    @if($user->active)
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
                                            :href="route('admin.users.edit', $user->id)"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                        <x-admin.table-actions-toggle :row-id="$user->id" />

                                    </div>
                                </td>

                            </tr>

                            <!-- Expanded actions -->
                            <tr x-cloak
                                x-show="openRow === {{ $user->id }}"
                                x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]"
                            >
                                <td colspan="5" class="px-4 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-3">

                                        <x-admin.table-action-button
                                            type="button"
                                            danger="true"
                                            wireClick="delete({{ $user->id }})"
                                            confirm="Soft delete this user?"
                                            icon="trash"
                                            label="Soft delete"
                                        />

                                        @if($user->role->key_name === 'app_user')
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="sendInvite({{ $user->id }}, true)"
                                                confirm="Send app invite to this user?"
                                                icon="paper-airplane"
                                                label="Send App Invite"
                                            />
                                        @else
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="sendInvite({{ $user->id }}, false)"
                                                confirm="Send installation instructions?"
                                                icon="paper-airplane"
                                                label="Send App Instructions"
                                            />
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-[var(--color-text-light)]">
                                    No team members found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </x-admin.table>

            <!-- Pagination -->
            <x-admin.pagination :paginator="$users" />

        </x-admin.card>

    </div>

</div>
