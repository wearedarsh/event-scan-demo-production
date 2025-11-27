<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Registrations'],
    ]" />



    <!-- ============================================================= -->
    <!-- PAGE HEADER -->
    <!-- ============================================================= -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Registrations</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage registrations, communication tools and payment filtering.
            </p>
        </div>

        <!-- Stat -->
        <div class="soft-card px-4 py-2 flex flex-col items-center">
            <span class="text-xs text-[var(--color-text-light)]">Total registrations</span>
            <span class="text-sm font-semibold">
                {{ $event->registrations->count() }}
            </span>
        </div>

    </div>



    <!-- Alerts -->
    @if($errors->any())
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
    <!-- COMMUNICATION -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">

    <x-admin.section-title title="Settings" />

        <div class="soft-card p-5 transition hover:shadow-md hover:-translate-y-0.5 ">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Communication</h3>
                    <p class="text-sm text-[var(--color-text-light)]">
                        Send emails to unpaid registrations.
                    </p>
                </div>

                 <x-link-arrow
                        href="{{ route('admin.events.emails.send-email', ['event' => $event->id, 'audience' => 'registrations_unpaid_complete', 'lock' => 1]) }}">
                        Email registrations
                </x-link-arrow>
            </div>
        </div>

    </div>




    <!-- ============================================================= -->
        <!-- REGISTRATIONS TABLE -->
        <!-- ============================================================= -->
        <div class="px-6">
            

            <div class="soft-card p-6 space-y-6">
                <x-admin.section-title title="Registrations" />

                <!-- Filters -->
                <div class="space-y-4">

                    <!-- Filter Pills -->
                    <div class="flex flex-wrap items-center gap-2">

                        <x-admin.filter-pill
                            :active="$paymentMethod === ''"
                            wire:click="$set('paymentMethod', '')"
                        >
                            All
                        </x-admin.filter-pill>

                        <x-admin.filter-pill
                            :active="$paymentMethod === 'stripe'"
                            wire:click="$set('paymentMethod', 'stripe')"
                        >
                            Stripe
                        </x-admin.filter-pill>

                        <x-admin.filter-pill
                            :active="$paymentMethod === 'bank_transfer'"
                            wire:click="$set('paymentMethod', 'bank_transfer')"
                        >
                            Bank Transfer
                        </x-admin.filter-pill>

                    </div>

                    <!-- Search -->
                    <div class="relative">
                        <x-heroicon-o-magnifying-glass
                            class="h-5 w-5 absolute left-3 top-1/2 -translate-y-1/2 text-[var(--color-text-light)]" />

                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Search email or last name"
                            class="w-full pl-10 pr-3 py-2 text-sm rounded-lg
                                bg-[var(--color-surface)] border border-[var(--color-border)]
                                focus:border-[var(--color-primary)]
                                focus:ring-2 focus:ring-[var(--color-primary)]/20
                                outline-none transition"
                        />
                    </div>

                </div>



                <!-- Table Container -->
                <div class="relative">

                    <!-- Scroll fade -->
                    <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                                bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm text-left">
                            <thead>
                                <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                                    @if ($this->roleKey === 'developer')
                                        <th class="px-4 py-3">ID</th>
                                    @endif
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Phone</th>
                                    <th class="px-4 py-3">Country</th>
                                    <th class="px-4 py-3">Payment</th>

                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody 
                                x-data="{ openRow: null }" 
                                @click.away="openRow = null"
                            >

                                @forelse($registrations as $reg)

                                    <!-- MAIN ROW -->
                                    <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                        @if ($this->roleKey === 'developer')
                                            <td class="px-4 py-3">{{ $reg->id }}</td>
                                        @endif

                                        <td class="px-4 py-3">
                                            {{ $reg->title }} {{ $reg->last_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <a href="mailto:{{ $reg->user->email }}">
                                                {{ $reg->user->email }}
                                            </a>
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $reg->mobile_country_code }}{{ $reg->mobile_number }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $reg->country->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <x-admin.status-pill status="info">
                                                {{ $reg->eventPaymentMethod->name }}
                                            </x-admin.status-pill>
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end items-center gap-2">

                                                <!-- Manage -->
                                                <x-admin.table-action-button
                                                    type="link"
                                                    :href="route('admin.events.registrations.manage', ['event' => $event->id, 'attendee' => $reg->id])"
                                                    icon="arrow-right-circle"
                                                    label="Manage"
                                                />

                                                <!-- Toggle -->
                                                <x-admin.table-actions-toggle 
                                                    :row-id="$reg->id" 
                                                />

                                            </div>
                                        </td>

                                    </tr>



                                    <!-- EXPANDED ACTION ROW -->
                                    <tr
                                        x-cloak
                                        x-show="openRow === {{ $reg->id }}"
                                        x-transition.duration.150ms
                                        class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]"
                                    >
                                        <td colspan="{{ $this->roleKey === 'developer' ? 7 : 6 }}" class="px-4 py-4">

                                            <div class="flex flex-wrap items-center justify-end gap-3">

                                                <!-- Edit -->
                                                <x-admin.table-action-button
                                                    type="link"
                                                    :href="route('admin.events.registrations.edit', ['event' => $event->id, 'attendee' => $reg->id])"
                                                    icon="pencil-square"
                                                    label="Edit"
                                                />

                                                <!-- Soft Delete -->
                                                <x-admin.table-action-button
                                                    type="button"
                                                    danger="true"
                                                    confirm="Soft delete this registration?"
                                                    wireClick="delete({{ $reg->id }})"
                                                    icon="trash"
                                                    label="Soft delete"
                                                />

                                            </div>

                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" 
                                            class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                            No registrations found.
                                        </td>
                                    </tr>

                                @endforelse
                            </tbody>
                        </table>

                    </div>

                </div>



                <!-- Pagination -->
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-xs text-[var(--color-text-light)] ms-4">
                        Showing {{ $registrations->firstItem() }}–{{ $registrations->lastItem() }}
                        of {{ $registrations->total() }}
                    </div>

                    <div>
                        {{ $registrations->links('pagination::tailwind') }}
                    </div>
                </div>

            </div>
        </div>


</div>
