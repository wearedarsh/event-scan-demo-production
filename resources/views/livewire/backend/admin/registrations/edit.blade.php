<div class="space-y-6">

    <!-- ============================================================= -->
    <!-- Breadcrumbs -->
    <!-- ============================================================= -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Registrations', 'href' => route('admin.events.registrations.index', $event->id)],
        ['label' => $attendee->title . ' ' . $attendee->last_name, 'href' => route('admin.events.registrations.manage', [$event->id, $attendee->id])],
        ['label' => 'Edit'],
    ]" />


    <!-- ============================================================= -->
    <!-- Page Header -->
    <!-- ============================================================= -->
    <div class="px-6">
        <h1 class="text-2xl font-semibold text-[var(--color-text)]">
            Edit registration
        </h1>
    </div>


    <!-- ============================================================= -->
    <!-- Alerts -->
    <!-- ============================================================= -->
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
    <!-- FORM WRAPPER -->
    <!-- ============================================================= -->
    <div class="px-6">

        <form wire:submit.prevent="update" class="space-y-6">


            <!-- ============================================================= -->
            <!-- CONTACT DETAILS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Contact details" />

            <div class="soft-card p-6 grid md:grid-cols-2 gap-6">

                <!-- Mobile -->
                <div>
                    <label class="form-label-custom">Mobile country code</label>
                    <input 
                        type="text"
                        wire:model.live="mobile_country_code"
                        class="input-text"
                    />
                </div>

                <div>
                    <label class="form-label-custom">Mobile number</label>
                    <input 
                        type="text"
                        wire:model.live="mobile_number"
                        class="input-text"
                    />
                </div>

                <!-- Address -->
                <div>
                    <label class="form-label-custom">Address line one</label>
                    <input 
                        type="text"
                        wire:model.live="address_line_one"
                        class="input-text"
                    />
                </div>

                <div>
                    <label class="form-label-custom">Town / City</label>
                    <input 
                        type="text"
                        wire:model.live="town"
                        class="input-text"
                    />
                </div>

                <div>
                    <label class="form-label-custom">Postcode</label>
                    <input 
                        type="text"
                        wire:model.live="postcode"
                        class="input-text"
                    />
                </div>

            </div>



            <!-- ============================================================= -->
            <!-- PROFESSIONAL DETAILS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Professional details" />

            <div class="soft-card p-6 grid md:grid-cols-2 gap-6">

                <!-- Position -->
                <div>
                    <label class="form-label-custom">Company</label>
                    <input 
                        type="text"
                        wire:model.live="currently_held_position"
                        class="input-text"
                    />
                </div>

                <!-- Attendee type -->
                <div>
                    <label class="form-label-custom">Profession</label>
                    <x-admin.select wire:model.live="attendee_type_id">
                        <option value="">Select attendee type</option>
                        @foreach ($attendeeTypes as $attendeeType)
                            <option value="{{ $attendeeType->id }}">
                                {{ $attendeeType->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                </div>

            </div>



            <!-- ============================================================= -->
            <!-- ACTION BUTTONS -->
            <!-- ============================================================= -->
            <div class="soft-card p-6 flex items-center gap-3">

                <!-- Save button -->
                <button type="submit"
                    class="inline-flex items-center rounded-md border border-[var(--color-primary)]
                           bg-[var(--color-surface)] px-3 py-1.5 text-sm font-medium
                           text-[var(--color-primary)]
                           hover:bg-[var(--color-primary)] hover:text-white
                           transition">
                    Update registration
                </button>

                <!-- Cancel -->
                <a href="{{ route('admin.events.registrations.manage', [$event->id, $attendee->id]) }}"
                   class="btn-secondary">
                    Cancel
                </a>

            </div>


        </form>

    </div>

</div>
