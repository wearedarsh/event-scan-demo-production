<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Email broadcasts', 'href' => route('admin.events.emails.broadcasts.index', $event->id)],
        ['label' => 'Broadcast with multiple recipients'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Broadcast with multiple recipients"
        subtitle="All recipients for the broadcast."
    >
        <div class="flex items-center gap-3">
            <x-admin.stat-card label="Recipients"
                :value="$broadcast->sentCount()" />

            <x-admin.stat-card label="Opened"
                :value="$broadcast->sends->sum('opens_count')" />

            <x-admin.stat-card label="Clicked"
                :value="$broadcast->sends->sum('clicks_count')" />
        </div>
    </x-admin.page-header>

    <!-- Card -->
    <x-admin.card hover="false" class="p-6 mx-6 space-y-4">
        <div class="space-y-2">
        <x-admin.section-title title="Subject" />
        <p class="text-sm">
            {{ $broadcast->subject }}
        </p>
        </div>

        <x-admin.search-input
            wire:model.live.debounce.300ms="search"
            placeholder="Search by name or email"
        />

        <x-admin.table>
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Details</th>
                        <th class="px-4 py-3">Recipient</th>
                        <th class="px-4 py-3">Opens / Clicks</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sends as $send)
                        <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3">
                                <x-admin.status-pill status="neutral">{{ $send->status }}</x-admin.status-pill><br>
                                <span class="text-xs text-[var(--color-text)]/40">
                                    {{ $send->sent_at->diffForHumans() }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                {{ $send->recipient->title }}
                                {{ $send->recipient->first_name }}
                                {{ $send->recipient->last_name }}<br>
                                <x-link-arrow size="xs" href="mailto:{{ $send->email_address }}">
                                    {{ $send->email_address }}
                                </x-link-arrow>
                            </td>

                            <td class="px-4 py-3">{{ $send->opens_count }} / {{ $send->clicks_count }}</td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <x-admin.table-action-button
                                        type="link"
                                        primary
                                        icon="eye"
                                        label="View"
                                        :href="route('admin.emails.broadcasts.view', [
                                            'event' => $event->id,
                                            'email_send' => $send->id
                                        ])"
                                    />
                                    </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No recipients found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-admin.table>

        <x-admin.pagination :paginator="$sends" />

    </x-admin.card>

</div>
