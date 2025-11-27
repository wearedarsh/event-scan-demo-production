<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Team members'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                Team members
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage staff accounts, roles and access.
            </p>
        </div>

        <!-- Add Team Member -->
        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
            <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
            <span class="hidden md:inline">Add team member</span>
        </a>

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

    @if(session()->has('success'))
    <div class="px-6">
        <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
            <p class="text-sm text-[var(--color-success)] font-medium">
                {{ session('success') }}
            </p>
        </div>
    </div>
    @endif


    <!-- MAIN CONTENT -->
    <div class="px-6">



        <div class="soft-card p-6 space-y-6">
            <x-admin.section-title title="Team members" />

            <!-- ROLE FILTER PILLS -->
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
            <div class="relative max-w-md mt-1">

                <x-heroicon-o-magnifying-glass
                    class="h-5 w-5 absolute left-3 top-2.5 text-[var(--color-text-light)] pointer-events-none" />

                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search name or email..."
                    class="w-full pl-11 pr-3 py-2.5 text-sm rounded-lg bg-[var(--color-surface)]
                           border border-[var(--color-border)] focus:border-[var(--color-primary)]
                           focus:ring-2 focus:ring-[var(--color-primary)]/20 outline-none transition" />
            </div>


            <!-- TABLE -->
            <div class="relative">
                <div class="overflow-x-auto">

                    <div class="relative overflow-x-auto">

                        <!-- Right fade indicator -->
                        <div class="absolute right-0 top-0 bottom-0 w-6
                bg-gradient-to-l from-white pointer-events-none"></div>

                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="uppercase text-xs text-[var(--color-text-light)]
                       border-b border-[var(--color-border)]">
                                    <th class="px-4 py-3 text-left">Name</th>
                                    <th class="px-4 py-3 text-left">Email</th>
                                    <th class="px-4 py-3 text-left">Role</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                                @forelse($users as $user)
                                <tr class="group border-b border-[var(--color-border)]
                           hover:bg-[var(--color-surface-hover)] transition">

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
                                                label="Edit" />

                                            <x-admin.table-actions-toggle :row-id="$user->id" />
                                        </div>
                                    </td>

                                </tr>

                                <!-- Expanded actions -->
                                <tr x-cloak
                                    x-show="openRow === {{ $user->id }}"
                                    x-transition.duration.150ms
                                    class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                    <td colspan="5" class="px-4 py-4">
                                        <div class="flex flex-wrap items-center justify-end gap-3">

                                            <x-admin.table-action-button
                                                type="button"
                                                danger="true"
                                                wireClick="delete({{ $user->id }})"
                                                confirm="Soft delete this user?"
                                                icon="trash"
                                                label="Soft delete" />

                                            @if($user->role->key_name === 'app_user')
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="sendInvite({{ $user->id }}, true)"
                                                confirm="Send app invite to this user?"
                                                icon="paper-airplane"
                                                label="Send App Invite" />
                                            @else
                                            <x-admin.table-action-button
                                                type="button"
                                                wireClick="sendInvite({{ $user->id }}, false)"
                                                confirm="Send installation instructions?"
                                                icon="paper-airplane"
                                                label="Send App Instructions" />
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

                    </div>


                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex items-center justify-between">
                <div class="text-xs text-[var(--color-text-light)]">
                    Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}
                </div>

                <div>
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>

        </div>

    </div>

</div>