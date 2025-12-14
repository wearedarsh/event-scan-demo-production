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

        <div class="space-y-4">

            

            <!-- Other categories looped below -->
            <div class="flex flex-wrap items-start gap-4">

            <!-- Top categories (stacked) -->
            <div class="space-y-4">
                <x-admin.section-title title="All" />

                <x-admin.filter-pill
                    :active="$filter === 'all'"
                    wire:click="setFilter('all')">
                    All ({{ $counts['all'] }})
                </x-admin.filter-pill>
            </div>
                @foreach ($categories as $category)
                @php
                $categoryTotal = $category->types->sum(fn($t) => $counts[$t->id] ?? 0);
                @endphp

                @if ($categoryTotal > 0)
                <div class="space-y-2">
                    <x-admin.section-title :title="$category->label" />

                    <div class="flex flex-wrap gap-2">
                        @foreach ($category->types as $type)
                        @if (($counts[$type->id] ?? 0) > 0)
                        <x-admin.filter-pill
                            :active="$filter == $type->id"
                            wire:click="setFilter('{{ $type->id }}')">
                            {{ $type->label }} ({{ $counts[$type->id] }})
                        </x-admin.filter-pill>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>

        </div>





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
                        <th class="px-4 py-3">Recipients</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($broadcasts as $broadcast)
                        @if(!$broadcast->isBulk())
                            @php 
                                $is_bulk = false;
                                $send = $broadcast->sends->first(); 
                            @endphp
                        @else
                            @php 
                                $is_bulk = true; 
                            @endphp
                        @endif

                    <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                        <td class="px-4 py-3">
                            @if(!$is_bulk)
                                <x-admin.status-pill status="neutral">{{ $send->status }}</x-admin.status-pill><br>
                            @else
                                <x-admin.status-pill status="neutral">Bulk</x-admin.status-pill><br>
                            @endif
                            <span class="text-xs">
                                {{ $broadcast->type->category->label }}
                            </span><br>
                            <span class="text-xs text-[var(--color-text)]/40">
                                {{ $broadcast->queued_at->diffForHumans() }}
                            </span>
                            </p>
                        </td>

                        <!-- Recipient -->
                        <td class="px-4 py-3">
                            
                            @if($is_bulk)
                                <span class="text-xs  text-[var(--color-text)]/40">Sent to</span><br>
                                {{ $broadcast->sends_count }} recipients
                            @else
                                @if ($send->recipient)
                                    {{ $send->recipient->title }}
                                    {{ $send->recipient->first_name }}
                                    {{ $send->recipient->last_name }}<br>
                                    <x-link-arrow size="xs" href="mailto:{{ $send->email_address }}">
                                        {{ $send->email_address }}
                                    </x-link-arrow>
                                @else
                                    Team member
                                @endif
                                <x-link-arrow size="xs" href="mailto:{{ $send->email_address }}">
                                        {{ $send->email_address }}
                                </x-link-arrow>
                            @endif

                        </td>

                        <!-- Subject -->
                        <td class="px-4 py-3">
                            {{ $broadcast->subject }}
                        </td>
                        <!-- Actions -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end items-center gap-2">
                                @if($broadcast->isBulk())
                                <x-admin.table-action-button
                                    type="link"
                                    :href="route('admin.emails.broadcasts.show', ['event' => $event->id, 'broadcast' => $broadcast->id])"
                                    icon="eye"
                                    label="View"
                                    primary />

                                @else
                                <x-admin.table-action-button
                                    type="link"
                                    :href="route('admin.emails.broadcasts.view', ['event' => $event->id, 'email_send' => $send->id])"
                                    icon="eye"
                                    label="View"
                                    primary />
                                @endif
                            </div>
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