<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Content'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Content for {{ $event->title }}"
        subtitle="Manage website content and downloads for this event."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- EVENT CONTENT -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Event Content" />
                <x-admin.outline-btn-icon
                    :href="route('admin.events.content.create', ['event' => $event->id])"
                    icon="heroicon-o-plus">
                    Add Content
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 w-28">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse($event_contents as $content)

                        <tr
                            wire:key="content-row-{{ $content->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['content'][$content->id]"
                                    :id="$content->id"
                                    upMethod="moveContentUp"
                                    downMethod="moveContentDown" />
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $content->title }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.content.{{ $content->id }}"
                                        wire:keydown.enter="updateContentOrder({{ $content->id }})"
                                        class="rounded-sm text-xs"
                                    />

                                    <x-admin.table-order-input-enter
                                        :id="$content->id"
                                        method="updateContentOrder"
                                    />
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                @if($content->active)
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
                                        :href="route('admin.events.content.edit', [
                                            'event' => $event->id,
                                            'content' => $content->id
                                        ])"
                                        primary
                                        icon="pencil-square"
                                        label="Edit"
                                    />

                                    <x-admin.table-actions-toggle :row-id="$content->id" />
                                </div>
                            </td>

                        </tr>

                        <!-- Expanded Row -->
                        <tr
                            wire:key="content-expanded-{{ $content->id }}"
                            x-cloak
                            x-show="openRow === {{ $content->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="5" class="px-4 py-4">
                                <div class="flex justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteContent({{ $content->id }})"
                                        confirm="Delete this content?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true"
                                    />

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No content found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </x-admin.table>

        </x-admin.card>

    </div>


    <!-- EVENT DOWNLOADS -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <div class="flex items-center justify-between">
                <x-admin.section-title title="Event Downloads" />
                <x-admin.outline-btn-icon
                    :href="route('admin.events.downloads.create', ['event' => $event->id])"
                    icon="heroicon-o-plus">
                    Add Download
                </x-admin.outline-btn-icon>
            </div>

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3 w-6"></th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 w-28">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }">

                        @forelse($downloads as $download)

                        <tr
                            wire:key="download-row-{{ $download->id }}"
                            class="hover:bg-[var(--color-surface-hover)] transition border-b border-[var(--color-border)]">

                            <!-- Arrows -->
                            <td class="px-2 py-3">
                                <x-admin.table-order-up-down
                                    :order="$orders['downloads'][$download->id]"
                                    :id="$download->id"
                                    upMethod="moveDownloadUp"
                                    downMethod="moveDownloadDown" />
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $download->title }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <x-admin.table-order-input
                                        wire:model.defer="orders.downloads.{{ $download->id }}"
                                        wire:keydown.enter="updateDownloadOrder({{ $download->id }})"
                                        class="rounded-sm text-xs"
                                    />

                                    <x-admin.table-order-input-enter
                                        :id="$download->id"
                                        method="updateDownloadOrder"
                                    />
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                @if($download->active)
                                    <x-admin.status-pill status="success">Active</x-admin.status-pill>
                                @else
                                    <x-admin.status-pill status="danger">Inactive</x-admin.status-pill>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end items-center gap-2">

                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.events.downloads.edit', [
                                            'event' => $event->id,
                                            'download' => $download->id
                                        ])"
                                        primary
                                        icon="pencil-square"
                                        label="Edit"
                                    />

                                    <x-admin.table-actions-toggle :row-id="$download->id" />

                                </div>
                            </td>

                        </tr>

                        <tr
                            wire:key="download-expanded-{{ $download->id }}"
                            x-cloak
                            x-show="openRow === {{ $download->id }}"
                            x-transition.duration.150ms
                            class="bg-[var(--color-surface-hover)] border-b border-[var(--color-border)]">

                            <td colspan="5" class="px-4 py-4">
                                <div class="flex justify-end gap-3">

                                    <x-admin.table-action-button
                                        type="button"
                                        wireClick="deleteDownload({{ $download->id }})"
                                        confirm="Delete this download?"
                                        icon="trash"
                                        label="Delete"
                                        danger="true"
                                    />

                                </div>
                            </td>
                        </tr>
                        
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No downloads found.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </x-admin.table>

        </x-admin.card>

    </div>

</div>
