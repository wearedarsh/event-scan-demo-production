<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Edit Personnel'],
    ]" />

    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Edit Personnel</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Update personnel details and print their badge.
        </p>
    </div>


    <!-- Alerts -->
    @if ($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)]">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- PRINT LABEL -->
    <!-- ============================================================= -->
    <div class="px-6">

        <x-admin.section-title title="Print badge label" />

        <div class="soft-card p-6 space-y-6">

            <form method="GET"
                  action="{{ route('admin.events.personnel.label.export', [
                        'event' => $event->id,
                        'personnel' => $personnel->id
                  ]) }}"
                  target="_blank"
                  class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Left side -->
                    <div class="space-y-4">

                        <div>
                            <label class="form-label-custom">Label format</label>
                            <select name="mode" class="input-text">
                                <option value="overlay_core" selected>
                                    No Header — Avery (75×110 mm)
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label-custom mb-1">Sheet position</label>

                            <div class="flex gap-2">
                                @foreach([1,2,3,4] as $slot)
                                    <label class="cursor-pointer inline-flex items-center gap-2 
                                                border rounded-md px-3 py-2 text-sm
                                                text-[var(--color-text)] hover:bg-[var(--color-surface-hover)]">
                                        <input type="radio" name="slot" value="{{ $slot }}"
                                               @checked($slot === 1)>
                                        {{ $slot }}
                                    </label>
                                @endforeach
                            </div>

                            <p class="text-xs text-[var(--color-text-light)] mt-1">
                                1: top-left • 2: top-right • 3: bottom-left • 4: bottom-right
                            </p>
                        </div>

                        <!-- Outline button -->
                        <button type="submit"
                                class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                                       bg-[var(--color-surface)] px-3 py-2 text-sm font-medium
                                       text-[var(--color-primary)]
                                       hover:bg-[var(--color-primary)] hover:text-white
                                       transition-colors duration-150 w-full justify-center">
                            <x-heroicon-o-printer class="h-4 w-4 mr-1.5" />
                            Print label
                        </button>

                    </div>


                    <!-- Right side (sheet preview) -->
                    <div>
                        <div class="w-[150px] aspect-[210/297] border border-[var(--color-border)]
                                    rounded-lg relative mx-auto">

                            <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 text-[var(--color-text-light)]">
                                <div class="flex items-center justify-center border-b border-r p-4 text-xs">1</div>
                                <div class="flex items-center justify-center border-b p-4 text-xs">2</div>
                                <div class="flex items-center justify-center border-r p-4 text-xs">3</div>
                                <div class="flex items-center justify-center p-4 text-xs">4</div>
                            </div>

                        </div>

                        <p class="text-xs text-center text-[var(--color-text-light)] mt-2">
                            A4 layout preview (not interactive)
                        </p>
                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- ============================================================= -->
    <!-- UPDATE PERSONNEL -->
    <!-- ============================================================= -->
    <div class="px-6">

        <x-admin.section-title title="Update personnel" />

        <div class="soft-card p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Line 1</label>
                        <input type="text" class="input-text" wire:model.live="line_1">
                    </div>

                    <div>
                        <label class="form-label-custom">Line 2</label>
                        <input type="text" class="input-text" wire:model.live="line_2">
                    </div>

                    <div>
                        <label class="form-label-custom">Line 3</label>
                        <input type="text" class="input-text" wire:model.live="line_3">
                    </div>

                    <div>
                        <label class="form-label-custom">Group</label>
                        <x-admin.select wire:model.live="personnel_group_id">
                            <option value="">Select a group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </x-admin.select>
                    </div>

                </div>

                <div class="flex items-center gap-3 pt-2">

                    <!-- Outline Update button -->
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                               bg-[var(--color-surface)] px-3 py-2 text-sm font-medium
                               text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white
                               transition-colors duration-150">
                        <x-heroicon-o-check class="h-4 w-4 mr-1.5" />
                        Update
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
