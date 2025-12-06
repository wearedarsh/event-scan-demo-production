<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Edit personnel'],
    ]" />

    <!-- Page Header -->
    <x-admin.page-header
        title="Edit personnel"
        subtitle="Update personnel details and print their badge."
    />

    <!-- Alerts -->
    @if ($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif


    <!-- Print label -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Print badge label" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <form
                method="GET"
                action="{{ route('admin.events.personnel.label.export', ['event' => $event->id, 'personnel' => $personnel->id]) }}"
                target="_blank"
                class="space-y-6"
            >

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Left -->
                    <div class="space-y-4">

                        <div>
                            <x-admin.input-label>
                                Label format
                            </x-admin.input-label>

                            <select name="mode" class="input-text">
                                <option value="overlay_core" selected>No Header — Avery (75×110 mm)</option>
                            </select>
                        </div>

                        <div>
                            <x-admin.input-label>
                                Sheet position
                            </x-admin.input-label>

                            <div class="flex gap-2">
                                @foreach([1,2,3,4] as $slot)
                                    <label class="cursor-pointer inline-flex items-center gap-2 border rounded-md px-3 py-2 text-sm hover:bg-[var(--color-surface-hover)]">
                                        <input type="radio" name="slot" value="{{ $slot }}" @checked($slot === 1)>
                                        {{ $slot }}
                                    </label>
                                @endforeach
                            </div>

                            <p class="text-xs text-[var(--color-text-light)] mt-1">
                                1: top-left • 2: top-right • 3: bottom-left • 4: bottom-right
                            </p>
                        </div>

                        <x-admin.button type="submit" variant="outline" class="w-full justify-center">
                            <x-slot:icon>
                                <x-heroicon-o-printer class="h-4 w-4" />
                            </x-slot:icon>
                            Print label
                        </x-admin.button>

                    </div>

                    <!-- Right -->
                    <div class="flex flex-col items-center">

                        <div class="w-[150px] aspect-[210/297] border border-[var(--color-border)] rounded-lg relative">
                            <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 text-[var(--color-text-light)]">
                                <div class="flex items-center justify-center border-b border-r p-4 text-xs">1</div>
                                <div class="flex items-center justify-center border-b p-4 text-xs">2</div>
                                <div class="flex items-center justify-center border-r p-4 text-xs">3</div>
                                <div class="flex items-center justify-center p-4 text-xs">4</div>
                            </div>
                        </div>

                        <p class="text-xs text-[var(--color-text-light)] mt-2">
                            A4 layout preview (not interactive)
                        </p>

                    </div>

                </div>

            </form>

        </x-admin.card>

    </div>


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
