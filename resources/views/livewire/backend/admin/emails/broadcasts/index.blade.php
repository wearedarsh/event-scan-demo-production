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
                        <th class="px-4 py-3">Recipient</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($broadcasts as $broadcast)

                    @php $isBulk = $broadcast->sends_count > 1; @endphp

                    <tr class="border-b hover:bg-[var(--color-surface-hover)] transition">

                        <!-- Detail Column -->
                        <td class="px-4 py-3">

                            <strong>{{ $broadcast->friendly_name }}</strong><br>

                            <span class="text-xs text-[var(--color-text)]/40">
                                {{ $broadcast->type->label }}<br>
                                Created {{ $broadcast->created_at }}
                            </span>

                            
                            @php $send = $broadcast->sends->first(); @endphp

                            @if($send)
                            <br><br>
                            <span class="text-xs text-[var(--color-text)]/60">
                                {{ $send->email_address }}<br>
                                {{ $send->recipient?->full_name ?? 'Admin' }}
                            </span>
                            @endif
                

                        </td>

                        <!-- Stats -->
                        <td class="px-4 py-3">
                            {{ $broadcast->sends_count }}
                            <br>

                            <span class="text-xs text-[var(--color-text)]/40">
                                {{-- Bulk send: show first/last --}}
                                @if($isBulk)
                                    <p>Tommy</p>
                                @else
                                {{-- Single send: just show timestamp --}}
                                Sent 
                                @endif
                            </span>
                        </td>

                        <!-- Subject -->
                        <td class="px-4 py-3">
                            @if(!$isBulk)
                            
                            @else
                            <span class="text-xs text-[var(--color-text)]/40">Multiple subjects</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-4 py-3 text-right">
                            <x-admin.table-action-button
                                type="link"
                                :href="#"
                                icon="arrow-right-circle"
                                label="{{ $isBulk ? 'View campaign' : 'View email' }}"
                                primary />
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-[var(--color-text-light)]">
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