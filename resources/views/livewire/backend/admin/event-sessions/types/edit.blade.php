<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Edit Session Type'],
    ]" />

    <!-- Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Edit Session Type</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Update this session type’s details.
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


    <!-- FORM -->
    <div class="px-6">

        <div class="soft-card p-6 space-y-6">

            <x-admin.section-title title="Session type details" />

            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Friendly Name -->
                    <div>
                        <label class="form-label-custom">Friendly Name</label>
                        <input
                            type="text"
                            wire:model.live="friendly_name"
                            class="input-text"
                        >
                    </div>

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Is Active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3">

                    <!-- Update Button (outline) -->
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                               text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white
                               transition-colors duration-150">
                        <x-heroicon-o-check class="h-4 w-4 md:mr-1.5" />
                        <span class="hidden md:inline">Update session type</span>
                    </button>

                    <!-- Cancel -->
                    <a href="{{ route('admin.events.event-sessions.index', $event->id) }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
