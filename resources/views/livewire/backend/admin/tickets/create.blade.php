<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Tickets', 'href' => route('admin.events.tickets.index', $event->id)],
        ['label' => 'Create Ticket'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Create Ticket"
        subtitle="Define a new ticket for {{ $event->title }}."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form Container -->
    <div class="px-6">

        <x-admin.card class="p-6 space-y-6">

            <x-admin.section-title title="Ticket Details" />

            <form wire:submit.prevent="store" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Ticket Name -->
                    <x-admin.input-text
                        label="Ticket Name"
                        model="name"
                        class="w-full"
                    />

                    <!-- Price -->
                    <x-admin.input-text
                        label="Price (e.g., 600.00)"
                        model="price"
                        type="number"
                        step="0.01"
                        class="w-full"
                    />

                    <!-- Max Volume -->
                    <x-admin.input-text
                        label="Maximum Volume"
                        model="max_volume"
                        type="number"
                        class="w-full"
                    />

                    <!-- Display Order -->
                    <x-admin.input-text
                        label="Display Order"
                        model="display_order"
                        type="number"
                        class="w-full"
                    />

                    <!-- Ticket Group -->
                    <div>
                        <label class="form-label-custom">Ticket Group</label>
                        <x-admin.select wire:model.live="ticket_group_id">
                            <option value="">Select a Group</option>
                            @foreach ($ticket_groups as $group)
                                <option value="{{ $group->id }}">
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </x-admin.select>
                    </div>

                    <!-- Requires Document Upload -->
                    <div>
                        <label class="form-label-custom">Requires Document Upload?</label>
                        <x-admin.select wire:model.live="requires_document_upload">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <!-- Document Upload Copy -->
                    <div>
                        <label class="form-label-custom">Document Upload Copy</label>
                        <textarea
                            wire:model.live="requires_document_copy"
                            rows="4"
                            class="input-text min-h-[120px]"
                        ></textarea>
                    </div>

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Active?</label>
                        <x-admin.select wire:model.live="active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                    <!-- Display on FE -->
                    <div>
                        <label class="form-label-custom">Display on Event Info Page?</label>
                        <x-admin.select wire:model.live="display_front_end">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-admin.select>
                    </div>

                </div>

                <!-- Save Buttons -->
                <div class="flex items-center gap-3 pt-4">
                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Create Ticket
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
