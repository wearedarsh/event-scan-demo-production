<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Email templates']
    ]" />


    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Email templates</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage your system-wide reusable email templates.
            </p>
        </div>

        
    </div>


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)] font-medium">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)] font-medium">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- MAIN CARD -->
    <!-- ============================================================= -->
    <div class="soft-card p-6 mx-6 space-y-4">

        <x-admin.section-title title="Templates" />


        <!-- Table -->
        <div class="relative">

            <!-- Scroll fade -->
            <div class="pointer-events-none absolute top-0 right-0 h-full w-8 
                        bg-gradient-to-l from-[var(--color-surface)] to-transparent"></div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-[var(--color-text-light)] uppercase text-xs border-b border-[var(--color-border)]">
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody x-data="{ openRow: null }" @click.away="openRow = null">

                        @forelse($emails as $email)

                            <!-- Row -->
                            <tr x-data
                                class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Title -->
                                <td class="px-4 py-3">
                                    {{ $email->title }}
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.templates.edit', ['email_html_content' => $email->id])"
                                            icon="pencil-square"
                                            label="Edit"
                                        />


                                    </div>
                                </td>
                            </tr>


                            

                        @empty

                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-[var(--color-text-light)]">
                                    No email templates found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>


        <!-- Pagination -->
        @if(method_exists($emails, 'links'))
            <div class="mt-4 flex items-center justify-end">
                {{ $emails->links('pagination::tailwind') }}
            </div>
        @endif

    </div>

</div>
