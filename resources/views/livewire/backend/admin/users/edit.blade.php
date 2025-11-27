<div class="space-y-6">

    <!-- Breadcrumb -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['label' => 'Team members', 'href' => route('admin.users.index')],
        ['label' => 'Edit team member'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">
                Edit team member
            </h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Update profile information, role and access.
            </p>
        </div>

    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-warning)]">
                <p class="text-sm text-[var(--color-warning)] font-medium">
                    {{ $errors->first() }}
                </p>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="px-6">
            <div class="soft-card p-4 border-l-4 border-[var(--color-success)]">
                <p class="text-sm text-[var(--color-success)] font-medium">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif



    <!-- ============================================================= -->
    <!-- MAIN FORM CARD -->
    <!-- ============================================================= -->
    <div class="px-6 space-y-4">

        <x-admin.section-title title="Team member details" />

        <form wire:submit.prevent="update" class="soft-card p-6 space-y-6">

            <div class="grid md:grid-cols-2 gap-6">

                <!-- First name -->
                <div>
                    <label class="form-label-custom">First name</label>
                    <input type="text" wire:model.live="first_name" class="input-text" />
                </div>

                <!-- Last name -->
                <div>
                    <label class="form-label-custom">Last name</label>
                    <input type="text" wire:model.live="last_name" class="input-text" />
                </div>

                <!-- Email -->
                <div>
                    <label class="form-label-custom">Email</label>
                    <input type="email" wire:model.live="email" class="input-text" />
                </div>

                <!-- Role -->
                <div>
                    <label class="form-label-custom">Role</label>
                    <x-admin.select wire:model="role_id">
                        <option value="">Select role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-admin.select>
                </div>

                <!-- Active status -->
                <div>
                    <label class="form-label-custom">Active status</label>
                    <x-admin.select wire:model="active">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </x-admin.select>
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                border border-[var(--color-primary)] text-[var(--color-primary)]
                                hover:bg-[var(--color-primary)] hover:text-white
                                transition">
                    Update team member
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
