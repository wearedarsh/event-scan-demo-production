<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Email Signatures'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Email Signatures"
        subtitle="Manage reusable signatures for outgoing emails."
    >
        <x-admin.outline-btn-icon
            :href="route('admin.emails.signatures.create')"
            icon="heroicon-o-plus">
            New Signature
        </x-admin.outline-btn-icon>
    </x-admin.page-header>


    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Signatures Table -->
    <div class="px-6">

        <x-admin.card class="p-5 space-y-4">

            <x-admin.section-title title="Signatures" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-xs uppercase text-[var(--color-text-light)] border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($signatures as $signature)

                            <tr
                                wire:key="signature-row-{{ $signature->id }}"
                                class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition"
                            >

                                <td class="px-4 py-3 font-medium">
                                    {{ $signature->title }}
                                </td>

                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.signatures.edit', $signature->id)"
                                            icon="pencil-square"
                                            label="Edit"
                                        />

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="2"
                                    class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No signatures found.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </x-admin.table>

            <!-- Pagination -->
            @if(method_exists($signatures, 'links'))
                <div class="flex justify-end pt-2">
                    {{ $signatures->links('pagination::tailwind') }}
                </div>
            @endif

        </x-admin.card>

    </div>

</div>
