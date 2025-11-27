<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => 'Edit Event'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Edit Event</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Update core details and configuration.
            </p>
        </div>
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
        <form wire:submit.prevent="update" class="space-y-3">

            <!-- ============================================================= -->
            <!-- EVENT DETAILS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Event details" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Title</label>
                        <input type="text" wire:model.live="title" class="input-text" />
                    </div>

                    <div>
                        <label class="form-label-custom">Location</label>
                        <input type="text" wire:model.live="location" class="input-text" />
                    </div>

                    <div>
                        <label class="form-label-custom">Start Date</label>
                        <input type="text" wire:model.live="date_start" class="input-text datepicker" autocomplete="off">
                    </div>

                    <div>
                        <label class="form-label-custom">End Date</label>
                        <input type="text" wire:model.live="date_end" class="input-text datepicker" autocomplete="off">
                    </div>

                    <div>
                        <label class="form-label-custom">Attendee Limit</label>
                        <input type="text" wire:model.live="event_attendee_limit" class="input-text" />
                    </div>

                    <div>
                        <label class="form-label-custom">VAT Percentage</label>
                        <input type="text" wire:model.live="vat_percentage" class="input-text" />
                    </div>
                </div>
            </div>



            <!-- ============================================================= -->
            <!-- EVENT STATUS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Event status" />

            <div class="soft-card p-6 space-y-3">
                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Is the event active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <label class="form-label-custom">Is the event full?</label>
                        <x-admin.select wire:model.live="full">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <label class="form-label-custom">Is the event provisional?</label>
                        <x-admin.select wire:model.live="provisional">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <label class="form-label-custom">Is this event a template?</label>
                        <x-admin.select wire:model.live="template">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>
            </div>



            <!-- ============================================================= -->
            <!-- EMAIL MARKETING -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Email marketing" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="form-label-custom">Auto email opt-in?</label>
                        <x-admin.select wire:model.live="auto_email_opt_in">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <div>
                        <label class="form-label-custom">Show opt-in statement?</label>
                        <x-admin.select wire:model.live="show_email_marketing_opt_in">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <div>
                    <label class="form-label-custom">Email opt-in description</label>
                    <textarea wire:model.live="email_opt_in_description" rows="4" class="input-textarea"></textarea>
                </div>
            </div>



            <!-- ============================================================= -->
            <!-- ACTION BUTTONS -->
            <!-- ============================================================= -->
            <div class="soft-card p-6 space-y-3">
                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        Update Event
                    </button>

                    <a href="{{ route('admin.events.manage', $event->id) }}" class="btn-secondary">
                        Cancel
                    </a>
                </div>
            </div>

        </form>
    </div>

</div>
