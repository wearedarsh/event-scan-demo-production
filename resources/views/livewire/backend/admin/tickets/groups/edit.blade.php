<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Ticket Groups', 'href' => route('admin.events.tickets.index', $event->id)],
        ['label' => 'Edit Ticket Group'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit Ticket Group"
        subtitle="Update details for this ticket group."
    />

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Group Details" />

            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Group Name -->
                    <x-admin.input-text
                        label="Group Name"
                        model="name"
                        class="w-full"
                    />

                    <!-- Description -->
                    <x-admin.input-text
                        label="Description"
                        model="description"
                        class="w-full"
                    />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        model="display_order"
                        type="number"
                        class="w-full"
                    />

                    <!-- Allow Multiple Selection -->
                    <div>
                        <label class="form-label-custom">Allow Multiple Selection?</label>
                        <x-admin.select wire:model.live="multiple_select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <!-- Required -->
                    <div>
                        <label class="form-label-custom">Is Required?</label>
                        <x-admin.select wire:model.live="required">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
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

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Update
                    </x-admin.button>

                    <a href="{{ route('admin.events.tickets.index', $event->id) }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </x-admin.card>

    </div>

</div>
