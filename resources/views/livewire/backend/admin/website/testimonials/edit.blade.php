<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Website', 'href' => route('admin.website.index')],
        ['label' => 'Testimonials', 'href' => route('admin.website.testimonials.index')],
        ['label' => 'Edit Testimonial'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit Testimonial"
        subtitle="Update testimonial content and display configuration."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if(session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- FORM WRAPPER -->
    <div class="px-6 space-y-6">

        <form wire:submit.prevent="update" class="space-y-6">

            <!-- BASIC INFORMATION -->
            <x-admin.section-title title="Basic Information" />

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
                            placeholder="e.g. Puskás Attila"
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
                            placeholder="e.g. MD, PhD"
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


            <!-- DISPLAY SETTINGS -->
            <x-admin.section-title title="Display Settings" />

            <x-admin.card hover="false" class="p-6 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Star Rating -->
                    <div>
                        <x-admin.input-label for="star_rating">
                            Star Rating (1–5)
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="star_rating"
                            model="star_rating"
                            type="number"
                            min="1"
                            max="5"
                            step="1"
                        />
                    </div>

                    <!-- Display Order -->
                    <div>
                        <x-admin.input-label for="display_order">
                            Display Order
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="display_order"
                            model="display_order"
                            type="number"
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


            <!-- ACTION BUTTONS -->
            <x-admin.card hover="false" class="p-6 space-y-4">
                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        Update testimonial
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
