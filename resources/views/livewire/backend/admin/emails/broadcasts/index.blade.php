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
        subtitle="Review all emails sent for {{ $event->title }}."
    />

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
                        <th class="px-4 py-3">Recipient</th>
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
                                    @if($broadcast->isBulk)
                                        3 recipients
                                    @endif
                                    
                                </p> 
                            </td>

                            <!-- Recipient -->
                            <td class="px-4 py-3">
                                @if ($email_send->recipient)
                                        {{ $email_send->recipient->title }}
                                        {{ $email_send->recipient->first_name }}
                                        {{ $email_send->recipient->last_name }}
                                    <br>
                                @else
                                    Admin<br>
                                @endif

                                <a
                                    href="mailto:{{ $email_send->email_address }}"
                                    class="text-xs text-[var(--color-text-light)]"
                                >
                                    {{ $email_send->email_address }}
                                </a>
                            </td>

                            <!-- Subject -->
                            <td class="px-4 py-3">
                                {{ $email_send->subject }}
                            </td>
                            <!-- Actions -->
                            <td class="px-4 py-3 text-right">
                                <x-admin.table-action-button
                                    type="link"
                                    :href="route('admin.emails.broadcasts.view', [
                                        'email_send' => $email_send->id,
                                        'event' => $event->id,
                                    ])"
                                    icon="arrow-right-circle"
                                    label="View details"
                                    primary
                                />
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
        <x-admin.pagination :paginator="$email_sends" />

    </x-admin.card>

</div>
