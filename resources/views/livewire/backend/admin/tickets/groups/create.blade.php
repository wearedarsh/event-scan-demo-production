<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Ticket Groups', 'href' => route('admin.events.tickets.index', $event->id)],
        ['label' => 'Create Ticket Group'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create Ticket Group"
        subtitle="Define a new ticket group for {{ $event->title }}."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Ticket Group Details" />

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Group Name -->
                    <x-admin.input-text
                        label="Group Name"
                        model="name"
                        class="w-full"
                    />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        model="display_order"
                        type="number"
                        class="w-full"
                    />

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

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

                </div>

                <!-- Description -->
                <div>
                    <label class="form-label-custom">Description</label>
                    <textarea
                        wire:model.live="description"
                        rows="4"
                        class="input-text min-h-[120px]"
                    ></textarea>
                </div>


                <!-- Buttons -->
                <div class="flex items-center gap-3">
                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Create group
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
