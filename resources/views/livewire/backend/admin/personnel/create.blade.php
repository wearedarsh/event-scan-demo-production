<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Add Personnel'],
    ]" />

    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">Add Personnel</h1>
        <p class="text-sm text-[var(--color-text-light)] mt-1">
            Create a new personnel record for this event.
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
    <!-- FORM WRAPPER -->
    <!-- ============================================================= -->
	  
    <div class="px-6">
		
       

        <div class="soft-card p-6 space-y-6">
			<x-admin.section-title title="Create personnel" />

            <form wire:submit.prevent="store" class="space-y-6">

                <!-- 2 columns -->
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

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">
					<!-- Add Personnel -->
				<button type="submit"
					class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                  bg-[var(--color-surface)] px-2.5 py-1.5 text-xs md:text-sm font-medium
                  text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-white
                  transition-colors duration-150">
					<x-heroicon-o-plus class="h-4 w-4 md:mr-1.5" />
					<span class="hidden md:inline">Create</span>
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
