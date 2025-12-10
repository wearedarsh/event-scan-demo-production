<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Email templates', 'href' => route('admin.emails.templates.index')],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Email Templates"
        subtitle="Manage reusable system-wide HTML email templates."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Templates Table -->
    <div class="px-6 space-y-4">

        <x-admin.card class="p-5 space-y-4">

            <x-admin.section-title title="Templates" />

            <x-admin.table>
                <table class="min-w-full text-sm text-left">

                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($emails as $email)

                            <tr class="border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Template Title -->
                                <td class="px-4 py-3">
                                    {{ $email->title }}
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.templates.edit', [
                                                'email_html_content' => $email->id
                                            ])"
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
                                    No email templates found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </x-admin.table>


            <!-- Pagination -->
            @if (method_exists($emails, 'links'))
                <div class="pt-4 flex items-center justify-end">
                    {{ $emails->links('pagination::tailwind') }}
                </div>
            @endif

        </x-admin.card>

    </div>

</div>
