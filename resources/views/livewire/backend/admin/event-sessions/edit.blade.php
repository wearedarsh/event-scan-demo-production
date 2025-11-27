<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Event Sessions', 'href' => route('admin.events.event-sessions.index', $event->id)],
        ['label' => $group->friendly_name, 'href' => route('admin.events.event-sessions.manage', [$event->id, $group->id])],
        ['label' => 'Edit Session']
    ]" />


    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            Edit Session – {{ $group->friendly_name }}
        </h1>

        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Update details for this event session.
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

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)]">{{ session('success') }}</p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- FORM WRAPPER -->
    <!-- ============================================================= -->
    <div class="px-6">

        <div class="soft-card p-6 space-y-6">

            <x-admin.section-title title="Update session details" />

            <form wire:submit.prevent="update" class="space-y-6">

                <!-- Two column grid -->
                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Title</label>
                        <input wire:model.live="title" type="text" class="input-text">
                    </div>

                    <div>
                        <label class="form-label-custom">Start Time</label>
                        <input wire:model.live="start_time" type="time" class="input-text">
                    </div>

                    <div>
                        <label class="form-label-custom">End Time</label>
                        <input wire:model.live="end_time" type="time" class="input-text">
                    </div>

                    <div>
                        <label class="form-label-custom">CME Points</label>
                        <input wire:model.live="cme_points" type="text" class="input-text">
                    </div>

                    <div>
                        <label class="form-label-custom">Display Order</label>
                        <input wire:model.live="display_order" type="number" class="input-text">
                    </div>

                    <div>
                        <label class="form-label-custom">Session Type</label>
                        <x-admin.select wire:model.live="event_session_type_id">
                            <option value="">Select a type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->friendly_name }}</option>
                            @endforeach
                        </x-admin.select>
                    </div>

                </div>


                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">

                    <!-- Outline Update Button -->
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                               text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white
                               transition-colors duration-150">
                        <x-heroicon-o-check class="h-4 w-4 md:mr-1.5" />
                        <span class="hidden md:inline">Update Session</span>
                    </button>

                    <a href="{{ route('admin.events.event-sessions.manage', [$event->id, $group->id]) }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
