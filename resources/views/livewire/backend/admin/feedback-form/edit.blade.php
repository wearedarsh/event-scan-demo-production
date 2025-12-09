<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Events', 'href' => route('admin.events.index')],
        ['label' => $event->title, 'href' => route('admin.events.manage', $event->id)],
        ['label' => 'Feedback Forms', 'href' => route('admin.events.feedback-form.index', $event->id)],
        ['label' => 'Edit feedback form'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Edit Feedback Form"
        subtitle="{{ $event->title }}"
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Form -->
    <div class="px-6">

        <form wire:submit.prevent="update" class="space-y-6">

            <x-admin.card hover="false" class="p-6 space-y-6">

                <x-admin.section-title title="Form details" />

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Title -->
                    <div>
                        <x-admin.input-label for="title">Title</x-admin.input-label>
                        <x-admin.input-text
                            id="title"
                            model="title"
                        />
                    </div>

                    <!-- Active -->
                    <div>
                        <x-admin.input-label for="active">Active</x-admin.input-label>
                        <x-admin.select id="active" wire:model="active">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <!-- Anonymous -->
                    <div>
                        <x-admin.input-label for="is_anonymous">Anonymous responses</x-admin.input-label>
                        <x-admin.select id="is_anonymous" wire:model="is_anonymous">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                    <!-- Multi-step -->
                    <div>
                        <x-admin.input-label for="multi_step">Multi-step form</x-admin.input-label>
                        <x-admin.select id="multi_step" wire:model="multi_step">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </x-admin.select>
                    </div>

                </div>

            </x-admin.card>


            <!-- Actions -->
            <x-admin.card hover="false" class="p-6 space-y-4">
                <div class="flex items-center gap-3">

                    <x-admin.button type="submit" variant="outline">
                        Update feedback form
                    </x-admin.button>

                    <x-admin.button
                        href="{{ route('admin.events.feedback-form.index', $event->id) }}"
                        variant="secondary">
                        Cancel
                    </x-admin.button>

                </div>
            </x-admin.card>

        </form>

    </div>

</div>
