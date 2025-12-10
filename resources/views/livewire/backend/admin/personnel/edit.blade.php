<div class="space-y-4">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Edit personnel'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit personnel"
        subtitle="Update personnel details"
    />

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif


    <!-- Update personnel -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Update personnel" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <form wire:submit.prevent="update" class="space-y-6">

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <x-admin.input-label for="line_1">Line 1</x-admin.input-label>
                        <x-admin.input-text id="line_1" model="line_1" />
                    </div>

                    <div>
                        <x-admin.input-label for="line_2">Line 2</x-admin.input-label>
                        <x-admin.input-text id="line_2" model="line_2" />
                    </div>

                    <div>
                        <x-admin.input-label for="line_3">Line 3</x-admin.input-label>
                        <x-admin.input-text id="line_3" model="line_3" />
                    </div>

                    <div>
                        <x-admin.input-label for="personnel_group_id">Group</x-admin.input-label>

                        <x-admin.select id="personnel_group_id" wire:model.live="personnel_group_id">
                            <option value="">Select group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </x-admin.select>
                    </div>

                </div>

                <div class="flex items-center gap-3 pt-2">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-check class="h-4 w-4" />
                        </x-slot:icon>
                        Update
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.personnel.index', $event->id) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>

            </form>

        </x-admin.card>

    </div>

</div>
