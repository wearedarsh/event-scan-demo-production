<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Add Personnel'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Add personnel"
        subtitle="Create a new personnel record for this event."
    />


    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif


    <!-- Form -->
    <div class="px-6 space-y-6">

        <x-admin.section-title title="Personnel details" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <form wire:submit.prevent="store" class="space-y-6">

                <!-- Two-column layout -->
                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Line 1 -->
                    <div>
                        <x-admin.input-label for="line_1">
                            Line 1
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="line_1"
                            model="line_1"
                        />
                    </div>

                    <!-- Line 2 -->
                    <div>
                        <x-admin.input-label for="line_2">
                            Line 2
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="line_2"
                            model="line_2"
                        />
                    </div>

                    <!-- Line 3 -->
                    <div>
                        <x-admin.input-label for="line_3">
                            Line 3
                        </x-admin.input-label>

                        <x-admin.input-text
                            id="line_3"
                            model="line_3"
                        />
                    </div>

                    <!-- Group -->
                    <div>
                        <x-admin.input-label for="personnel_group_id">
                            Group
                        </x-admin.input-label>

                        <x-admin.select id="personnel_group_id" wire:model.live="personnel_group_id">
                            <option value="">Select group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                            @endforeach
                        </x-admin.select>
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">

                    <x-admin.button type="submit" variant="outline">
                        <x-slot:icon>
                            <x-heroicon-o-plus class="h-4 w-4" />
                        </x-slot:icon>
                        Create personnel
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
