<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Registrations'],
    ]" />


    <!-- Header -->
    <x-admin.page-header
        title="Registrations"
        subtitle="Manage registrations, communication tools and payment filtering."
    >
        <x-admin.stat-card 
            label="Total registrations"
            :value="$event->registrations->count()" 
        />
    </x-admin.page-header>


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif



    <!-- Communication -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Settings" />

        <x-admin.action-card
            title="Communication"
            description="Send emails to unpaid registrations."
        >
            <x-link-arrow
                href="{{ route('admin.events.emails.send-email', [
                    'event' => $event->id,
                    'audience' => 'registrations_unpaid_complete',
                    'lock' => 1
                ]) }}"
            >
                Email registrations
            </x-link-arrow>
        </x-admin.action-card>

    </div>



    <!-- Registrations Table -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Registrations" />

            <!-- Filters -->
            <div class="space-y-4">

                <!-- Payment method filter pills -->
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
                <x-admin.search-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search email or last name"
                />

            </div>



            <!-- Table -->
            <x-admin.table>
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

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($registrations as $reg)

                            <!-- Main row -->
                            <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                @if ($this->roleKey === 'developer')
                                    <td class="px-4 py-3">{{ $reg->id }}</td>
                                @endif

                                <td class="px-4 py-3 font-medium">
                                    {{ $reg->title }} {{ $reg->last_name }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="mailto:{{ $reg->user->email }}" class="hover:underline underline-offset-2">
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

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.registrations.manage', [$event->id, $reg->id])"
                                            icon="arrow-right-circle"
                                            label="Manage"
                                        />

                                        <x-admin.table-actions-toggle :row-id="$reg->id" />

                                    </div>
                                </td>

                            </tr>



                            <!-- Expanded action row -->
                            <tr x-cloak x-show="openRow === {{ $reg->id }}" x-transition.duration.150ms
                                class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                                <td colspan="{{ $this->roleKey === 'developer' ? 7 : 6 }}" class="px-4 py-4">

                                    <div class="flex flex-wrap items-center justify-end gap-3">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.events.registrations.edit', [$event->id, $reg->id])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

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
                                <td colspan="7" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No registrations found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>



            <!-- Pagination -->
            <x-admin.pagination :paginator="$registrations" />

        </x-admin.card>

    </div>

</div>
