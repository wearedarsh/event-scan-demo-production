<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Attendee Groups', 'href' => route('admin.events.attendees.groups.index', $event->id)],
        ['label' => 'Create Group'],
    ]" />


    <!-- Page Header -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            Create attendee group
        </h1>
    </div>


    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)] font-medium">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)] font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- FORM WRAPPER -->
    <!-- ============================================================= -->
    <div class="px-6">
        <form wire:submit.prevent="store" class="space-y-6">


            <!-- ============================================================= -->
            <!-- GROUP DETAILS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Group details" />

            <div class="soft-card p-6 space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label-custom">Group name</label>
                        <input 
                            type="text" 
                            wire:model.live="title" 
                            class="input-text"
                            placeholder="e.g. Faculty, Speakers, VIP"
                        />
                    </div>
                </div>
            </div>



            <!-- ============================================================= -->
            <!-- TWO-COLUMN BADGE COLOUR SETTINGS -->
            <!-- ============================================================= -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Background colour card -->
                <div class="soft-card p-6 space-y-4">
                    <h3 class="font-medium text-[var(--color-text)]">Badge background colour</h3>

                    <p class="text-sm text-[var(--color-text-light)] leading-relaxed">
                        This sets the <strong>background colour</strong> for this group's badge label.
                        Pick a colour that helps visually distinguish this group.
                    </p>

                    <div>
                        <label class="form-label-custom">Background colour</label>

                        <div class="w-24 h-12 rounded-lg overflow-hidden border border-[var(--color-border)] bg-[var(--color-surface)] flex items-center justify-center">
                            <input 
                                type="color" 
                                wire:model.live="colour" 
                                class="appearance-none cursor-pointer w-full h-full border-0 rounded-lg p-0"
                            />
                        </div>
                    </div>
                </div>


                <!-- Text colour card -->
                <div class="soft-card p-6 space-y-4">
                    <h3 class="font-medium text-[var(--color-text)]">Badge text colour</h3>

                    <p class="text-sm text-[var(--color-text-light)] leading-relaxed">
                        This sets the <strong>text colour</strong> used on the badge label.  
                        Choose a colour that contrasts well with the background for legibility.
                    </p>

                    <div>
                        <label class="form-label-custom">Text colour</label>

                        <div class="w-24 h-12 rounded-lg overflow-hidden border border-[var(--color-border)] bg-[var(--color-surface)] flex items-center justify-center">
                            <input 
                                type="color" 
                                wire:model.live="label_colour" 
                                class="appearance-none cursor-pointer w-full h-full border-0 rounded-lg p-0"
                            />
                        </div>
                    </div>
                </div>

            </div>



            <!-- ============================================================= -->
            <!-- ACTION BUTTONS -->
            <!-- ============================================================= -->
            <div class="soft-card p-6">

                <div class="flex items-center gap-3">

                    <button type="submit"
                        class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                               border border-[var(--color-primary)] text-[var(--color-primary)]
                               hover:bg-[var(--color-primary)] hover:text-white transition">
                        Create group
                    </button>

                    <a href="{{ route('admin.events.attendees.groups.index', $event->id) }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </div>

        </form>
    </div>

</div>
