<div class="space-y-4">

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


    <div class="px-6 space-y-4">

            <!-- Testimonials -->
            <x-admin.action-card
                title="Testimonials"
                icon="heroicon-o-chat-bubble-left-right"
                description="Manage the testimonials displayed on your public booking website.">

                <x-link-arrow href="{{ route('admin.website.testimonials.index') }}">
                    Manage testimonials
                </x-link-arrow>

            </x-admin.action-card>


    </div>

</div>
