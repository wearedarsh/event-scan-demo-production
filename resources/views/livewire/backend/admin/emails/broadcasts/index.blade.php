<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Email broadcasts'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Email broadcasts"
        subtitle="Review all emails sent for {{ $event->title }}." />

    <!-- Alerts -->
    @if ($errors->any())
    <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
    <x-admin.alert type="success" :message="session('success')" />
    @endif

    <!-- Main Card -->
    <x-admin.card hover="false" class="p-6 mx-6 space-y-4">

        <!-- Search -->
        <x-admin.search-input
            wire:model.live.debounce.300ms="search"
            placeholder="Search by email, name or subject" />

        <!-- Table -->
        <x-admin.table>
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-[var(--color-text-light)] font-light uppercase text-xs border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Detail</th>
                        <th class="px-4 py-3">Sent to</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($broadcasts as $broadcast)
                    <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                        <!-- Type -->
                        <td class="px-4 py-3">
                            <p class="text-xs text-[var(--color-text)]/40">
                                <span class="font-medium">{{ $broadcast->type->label }}</span><br>
                                {{ $broadcast->queued_at->diffForHumans() }}
                            </p>
                        </td>

                        <!-- Recipient -->
                        <td class="px-4 py-3">
                            @if($broadcast->isBulk())
                                {{ $broadcast->sends_count }} recipients
                            @else
                                @php $send = $broadcast->sends->first(); @endphp
                                    @if ($send->recipient)
                                        {{ $send->recipient->title }}
                                        {{ $send->recipient->first_name }}
                                        {{ $send->recipient->last_name }}
                                    @else
                                        Sent to admin
                                    @endif
                                </p>

                                <x-link-arrow size="xs" href="mailto:{{ $send->email_address }}">
                                    {{ $send->email_address }}
                                </x-link-arrow>
                            @endif
                        </td>

                        <!-- Subject -->
                        <td class="px-4 py-3">
                            <p class="text-xs"><span class="text-[var(--color-text)]/40">{{ $broadcast->friendly_name }}</span><br>
                                {{ $broadcast->subject }}
                            </p>
                            
                        </td>
                        <!-- Actions -->
                        <td class="px-4 py-3 text-right">
                            <x-admin.table-action-button
                                type="link"
                                :href="route('admin.dashboard')"
                                icon="arrow-right-circle"
                                label="View details"
                                primary />
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                            No broadcasts found for this event.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </x-admin.table>

        <!-- Pagination -->
        <x-admin.pagination :paginator="$broadcasts" />

    </x-admin.card>

</div>