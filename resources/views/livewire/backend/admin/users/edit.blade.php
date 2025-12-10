<div class="space-y-4">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Home', 'href' => route('admin.dashboard')],
        ['label' => 'Team members', 'href' => route('admin.users.index')],
        ['label' => 'Edit team member'],
    ]" />

    <!-- Header -->
    <x-admin.page-header
        title="Edit team member"
        subtitle="Update profile information, role and access."
    />

    <!-- Alerts -->
    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    @if (session()->has('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif


    <!-- Main form -->
    <div class="px-6 space-y-4">

        <!-- Information -->
        <x-admin.section-title title="Information" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <div class="grid md:grid-cols-2 gap-6">

                <!-- First name -->
                <div>
                    <x-admin.input-label for="first_name">First name</x-admin.input-label>
                    <x-admin.input-text id="first_name" model="first_name" />
                </div>

                <!-- Last name -->
                <div>
                    <x-admin.input-label for="last_name">Last name</x-admin.input-label>
                    <x-admin.input-text id="last_name" model="last_name" />
                </div>

                <!-- Email -->
                <div>
                    <x-admin.input-label for="email">Email</x-admin.input-label>
                    <x-admin.input-text id="email" model="email" type="email" />
                </div>

            </div>

        </x-admin.card>


        <!-- Account settings -->
        <x-admin.section-title title="Account settings" />

        <x-admin.card hover="false" class="p-6 space-y-6">

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Role -->
                <div>
                    <x-admin.input-label for="role_id">Role</x-admin.input-label>
                    <x-admin.select id="role_id" wire:model="role_id">
                        <option value="">Select role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                </div>

                <!-- Active -->
                <div>
                    <x-admin.input-label for="active">Active status</x-admin.input-label>
                    <x-admin.select id="active" wire:model="active">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </x-admin.select>
                </div>

            </div>

        </x-admin.card>


        <!-- Actions -->
        <x-admin.card hover="false" class="p-6 space-y-4">
            <div class="flex items-center gap-3">

                <x-admin.button type="submit" variant="outline" wire:click.prevent="update">
                    Update team member
                </x-admin.button>

                <x-admin.button href="{{ route('admin.users.index') }}" variant="secondary">
                    Cancel
                </x-admin.button>

            </div>
        </x-admin.card>

    </div>

</div>
