<div class="space-y-6">

    <!-- Breadcrumbs -->
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

    <div class="px-6">
        <form wire:submit.prevent="store" class="space-y-6">

            <!-- Basic Info -->
            <x-admin.section-title title="Basic information" />

            <div class="soft-card p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Title</label>
                        <input wire:model.live="title"
                               type="text"
                               class="input-text"
                               placeholder="e.g. Puskás Attila" />
                    </div>

                    <div>
                        <label class="form-label-custom">Subtitle</label>
                        <input wire:model.live="sub_title"
                               type="text"
                               class="input-text"
                               placeholder="e.g. MD, PhD" />
                    </div>

                </div>

                <div>
                    <label class="form-label-custom">Content</label>
                    <textarea wire:model.live="content"
                              rows="5"
                              class="input-textarea"
                              placeholder="Enter testimonial content"></textarea>
                </div>
            </div>

            <!-- Display Settings -->
            <x-admin.section-title title="Display settings" />

            <div class="soft-card p-6 space-y-4">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Star rating (1–5)</label>
                        <input wire:model.live="star_rating"
                               type="number"
                               min="1"
                               max="5"
                               step="1"
                               class="input-text"
                               placeholder="Enter star rating" />
                    </div>

                    <div>
                        <label class="form-label-custom">Display order</label>
                        <input wire:model.live="display_order"
                               type="number"
                               class="input-text"
                               placeholder="Order for sorting" />
                    </div>

                    <div>
                        <label class="form-label-custom">Active</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

            </div>

            <!-- Buttons -->
            <div class="soft-card p-6">
                <div class="flex items-center gap-3">

                    <button type="submit"
                            class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                   bg-[var(--color-surface)] px-3 py-2 text-sm font-medium
                                   text-[var(--color-primary)]
                                   hover:bg-[var(--color-primary)] hover:text-white
                                   transition">
                        Create testimonial
                    </button>

                    <a href="{{ route('admin.website.testimonials.index') }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>
            </div>

        </form>
    </div>

</div>
