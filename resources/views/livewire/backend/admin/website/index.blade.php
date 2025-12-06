<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Website'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Website"
        subtitle="Manage public-facing content for your booking website."
    />


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <x-admin.alert type="danger" :message="$errors->first()" />
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <x-admin.alert type="success" :message="session('success')" />
        </div>
    @endif


    <!-- Website Content -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Website content" />

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Testimonials -->
            <x-admin.tile-card
                title="Testimonials"
                description="Manage the testimonials displayed on your public booking website.">

                <x-link-arrow href="{{ route('admin.website.testimonials.index') }}">
                    Manage testimonials
                </x-link-arrow>

            </x-admin.tile-card>

            <!-- Future cards go here -->
            {{-- 
            <x-admin.tile-card title="FAQ" description="Manage your FAQ section."></x-admin.tile-card>
            <x-admin.tile-card title="SEO" description="Update metadata and SEO content."></x-admin.tile-card>
            --}}

        </div>

    </div>

</div>
