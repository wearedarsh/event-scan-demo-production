<div class="space-y-6">

    <!-- Breadcrumbs (NO dashboard) -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Website', 'href' => route('admin.website.index')],
        ['label' => 'Testimonials', 'href' => route('admin.website.testimonials.index')],
        ['label' => 'Create testimonial'],
    ]" />

    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Create testimonial</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Add a new testimonial to display on the website.
        </p>
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
    <!-- FORM WRAPPER -->
    <!-- ============================================================= -->
    <div class="px-6">
        <form wire:submit.prevent="store" class="space-y-6">

            <!-- BASIC INFORMATION -->
            <x-admin.section-title title="Basic Information" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div>
                        <label class="form-label-custom">Title</label>
                        <input wire:model.live="title"
                               type="text"
                               class="input-text"
                               placeholder="e.g. Puskás Attila" />
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="form-label-custom">Subtitle</label>
                        <input wire:model.live="sub_title"
                               type="text"
                               class="input-text"
                               placeholder="e.g. MD, PhD" />
                    </div>

                </div>

                <!-- Content -->
                <div>
                    <label class="form-label-custom">Content</label>
                    <textarea wire:model.live="content"
                              rows="5"
                              class="input-textarea"
                              placeholder="Enter testimonial content"></textarea>
                </div>

            </div>



            <!-- DISPLAY SETTINGS -->
            <x-admin.section-title title="Display Settings" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Star Rating -->
                    <div>
                        <label class="form-label-custom">Star Rating (1–5)</label>
                        <input wire:model.live="star_rating"
                               type="number"
                               min="1"
                               max="5"
                               step="1"
                               class="input-text"
                               placeholder="Enter star rating" />
                    </div>

                    <!-- Display Order -->
                    <div>
                        <label class="form-label-custom">Display Order</label>
                        <input wire:model.live="display_order"
                               type="number"
                               class="input-text"
                               placeholder="Order for sorting" />
                    </div>

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Active</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

            </div>



            <!-- ACTION BUTTONS -->
            <div class="soft-card p-6 space-y-3">
                <div class="flex items-center gap-3">

                    <!-- Create Button (outlined primary) -->
                    <button type="submit"
                            class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                   border border-[var(--color-primary)] text-[var(--color-primary)]
                                   hover:bg-[var(--color-primary)] hover:text-white
                                   transition">
                        Create testimonial
                    </button>

                    <!-- Cancel -->
                    <a href="{{ route('admin.website.testimonials.index') }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>
            </div>

        </form>
    </div>

</div>
