<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Website'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Website</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Manage public-facing content for your booking website.
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
    <!-- MAIN CONTENT -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Website content" />

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Testimonials -->
            <div class="soft-card p-6 space-y-4">
                
                <div class="flex items-center gap-3">
                    <h3 class="text-base font-medium">Testimonials</h3>
                </div>

                <p class="text-sm text-[var(--color-text-light)]">
                    Manage the testimonials displayed on the public booking website.
                </p>

                <div>
                    <a href="{{ route('admin.website.testimonials.index') }}"
                       class="inline-flex items-center gap-2 text-[var(--color-primary)] font-medium text-sm
                              hover:underline">
                        <span>Manage testimonials</span>
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </div>

            </div>

            <!-- (Add more website modules here later) -->
            <!-- Example placeholders for future expansion -->
            {{-- 
            <div class="soft-card p-6">
                <h3>FAQ</h3>
            </div>

            <div class="soft-card p-6">
                <h3>SEO Settings</h3>
            </div>
            --}}

        </div>

    </div>

</div>
