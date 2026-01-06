<div class="space-y-4">

    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Client Settings'],
    ]" />

    <x-admin.page-header
        title="Client Settings"
        subtitle="Manage client-facing configuration, branding, and content.">
    </x-admin.page-header>

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif

    <x-admin.card hover="false" class="p-6 mx-6 space-y-4">

        <x-admin.table>
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-[var(--color-text-light)] font-light uppercase text-xs border-b border-[var(--color-border)]">
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                            <td class="px-4 py-3">
                                <div class="font-medium text-[var(--color-text)]">
                                    {{ $category->label }}
                                </div>
                                <div class="text-xs text-[var(--color-text-light)]">
                                    key name: {{ $category->key_name }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex flex-wrap items-center justify-end gap-3">
                                    <x-admin.table-action-button
                                        type="link"
                                        :href="route('admin.developer.client-settings.manage', $category->id)"
                                        icon="arrow-right-circle"
                                        primary
                                        label="Manage" />
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                No client setting categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-admin.table>

    </x-admin.card>

</div>
