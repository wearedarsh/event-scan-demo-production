<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Create Personnel Group'],
    ]" />

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Create Personnel Group</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Add a new personnel group for organising badges and categories.
        </p>
    </div>


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif


    <!-- ============================================================= -->
    <!-- FORM -->
    <!-- ============================================================= -->
    <div class="px-6">

        <x-admin.section-title title="Group details" />

        <div class="soft-card p-6 space-y-6">

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div class="md:col-span-1">
                        <label class="form-label-custom">Group name</label>
                        <input type="text" wire:model.live="title" class="input-text">
                    </div>

                    <!-- Colours -->
                    <div class="grid grid-cols-2 gap-6 md:col-span-1">

                        <div>
                            <label class="form-label-custom">Label background</label>
                            <input type="color"
                                   wire:model.live="label_background_colour"
                                   class="h-16 w-16 rounded-md border border-[var(--color-border)] p-0 cursor-pointer" />
                        </div>

                        <div>
                            <label class="form-label-custom">Label text colour</label>
                            <input type="color"
                                   wire:model.live="label_colour"
                                   class="h-16 w-16 rounded-md border border-[var(--color-border)] p-0 cursor-pointer" />
                        </div>

                    </div>

                </div>


                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">

                    <!-- Outline Create button -->
                    <button type="submit"
                            class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                   bg-[var(--color-surface)] px-3 py-2 text-sm font-medium
                                   text-[var(--color-primary)]
                                   hover:bg-[var(--color-primary)] hover:text-white
                                   transition-colors duration-150">
                        <x-heroicon-o-plus class="h-4 w-4 mr-1.5" />
                        Create group
                    </button>

                    <a href="{{ route('admin.events.personnel.index', $event->id) }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
