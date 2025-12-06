<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Website', 'href' => route('admin.website.index')],
        ['label' => 'Testimonials', 'href' => route('admin.website.testimonials.index')],
        ['label' => 'Create testimonial'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create testimonial"
        subtitle="Add a new testimonial to display on the website."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main Form -->
    <div class="px-6 space-y-6">

        <form wire:submit.prevent="store" class="space-y-6">

            <!-- Basic Information -->
            <x-admin.section-title title="Basic information" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div>
                        <x-admin.input-label for="title">
                            Title
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="title"
                            model="title"
                            placeholder="e.g. Full Name"
                        />
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <x-admin.input-label for="sub_title">
                            Subtitle
                        </x-admin.input-label>
                        <x-admin.input-text
                            id="sub_title"
                            model="sub_title"
                            placeholder="e.g. Job title or company"
                        />
                    </div>

                </div>

                <!-- Content -->
                <div>
                    <x-admin.input-label for="content">
                        Content
                    </x-admin.input-label>

                    <x-admin.input-textarea
                        id="content"
                        model="content"
                        rows="5"
                        placeholder="Enter testimonial content"
                    />
                </div>

            </x-admin.card>


            <!-- Display Settings -->
            <x-admin.section-title title="Display settings" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Star Rating -->
                    <div>
                        <x-admin.input-label for="star_rating">
                            Star rating (1–5)
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="star_rating"
                            model="star_rating"
                            type="number"
                            min="1"
                            max="5"
                            step="1"
                            placeholder="Enter star rating"
                        />
                    </div>

                    <!-- Display Order -->
                    <div>
                        <x-admin.input-label for="display_order">
                            Display order
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="display_order"
                            model="display_order"
                            type="number"
                            placeholder="Order for sorting"
                        />
                    </div>

                    <!-- Active -->
                    <div>
                        <x-admin.input-label for="active">
                            Active
                        </x-admin.input-label>

                        <x-admin.select id="active" wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

            </x-admin.card>


            <!-- Buttons -->
            <x-admin.card hover="false" class="p-6 space-y-4">
                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        Create testimonial
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.website.testimonials.index') }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>
            </x-admin.card>

        </form>

    </div>

</div>
