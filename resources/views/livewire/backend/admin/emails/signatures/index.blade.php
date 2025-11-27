<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Email signatures']
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Email signatures</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage reusable email signatures for outgoing communications.
            </p>
        </div>

        <!-- Add Signature (future-proof) -->
        <div class="flex items-center gap-3">
            <a href=""
               class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                      bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                      text-[var(--color-primary)]
                      hover:bg-[var(--color-primary)] hover:text-white
                      transition-colors duration-150">
                <x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
                <span class="hidden md:inline">New signature</span>
            </a>
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

        <x-admin.section-title title="Signatures" />

        <!-- Table container -->
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

                        @forelse($signatures as $signature)

                            <!-- TABLE ROW -->
                            <tr x-data
                                class="group border-b border-[var(--color-border)] hover:bg-[var(--color-surface-hover)] transition">

                                <!-- Title -->
                                <td class="px-4 py-3">
                                    {{ $signature->title }}
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end items-center gap-2">

                                        <x-admin.table-action-button
                                            type="link"
                                            :href="route('admin.emails.signatures.edit', ['signature_html_content' => $signature->id])"
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
            </div>
        </div>

        <!-- Pagination (if using paginator) -->
        @if(method_exists($signatures, 'links'))
            <div class="mt-4 flex items-center justify-end">
                {{ $signatures->links('pagination::tailwind') }}
            </div>
        @endif

    </div>

</div>
