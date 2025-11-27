<div class="space-y-6">

    <!-- Breadcrumbs -->
    <x-admin.breadcrumb :items="[
        ['label' => 'Team members', 'href' => route('admin.users.index')],
        ['label' => 'Add team member'],
    ]" />

    <!-- Page Header -->
    <div class="px-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[var(--color-text)]">Add team member</h1>
            <p class="text-sm text-[var(--color-text-light)] mt-1">
                Create a new team member and assign permissions.
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

    @if(session('success'))
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
        <form wire:submit.prevent="save" class="space-y-6">


            <!-- ============================================================= -->
            <!-- USER INFORMATION -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Information" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- First name -->
                    <div>
                        <label class="form-label-custom">First Name</label>
                        <input wire:model.live="first_name" type="text" class="input-text">
                    </div>

                    <!-- Last name -->
                    <div>
                        <label class="form-label-custom">Last Name</label>
                        <input wire:model.live="last_name" type="text" class="input-text">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="form-label-custom">Email</label>
                        <input wire:model.live="email" type="email" class="input-text">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="form-label-custom">Password</label>
                        <input wire:model.live="password" type="password" class="input-text">
                        <p class="text-xs text-[var(--color-text-light)] mt-1">
                            Must be at least 8 characters.
                        </p>
                    </div>

                </div>

            </div>



            <!-- ============================================================= -->
            <!-- ACCOUNT SETTINGS -->
            <!-- ============================================================= -->
            <x-admin.section-title title="Account Settings" />

            <div class="soft-card p-6 space-y-3">

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- Role -->
                    <div>
                        <label class="form-label-custom">Role</label>
                        <x-admin.select wire:model.live="role_id">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-admin.select>
                    </div>

                    <!-- Active -->
                    <div>
                        <label class="form-label-custom">Active Status</label>
                        <x-admin.select wire:model.live="active">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </x-admin.select>
                    </div>

                </div>

            </div>



            <!-- ============================================================= -->
            <!-- ACTION BUTTONS -->
            <!-- ============================================================= -->
            <div class="soft-card p-6 space-y-3">

                <div class="flex items-center gap-3">

                    <!-- PRIMARY OUTLINED BUTTON (your requested style) -->
                    <button type="submit"
                            class="flex items-center px-3 py-1.5 rounded-md text-sm font-medium
                                   border border-[var(--color-primary)] text-[var(--color-primary)]
                                   hover:bg-[var(--color-primary)] hover:text-white
                                   transition">
                        Add team member
                    </button>

                    <!-- Cancel -->
                    <a href="{{ route('admin.users.index') }}"
                       class="btn-secondary">
                        Cancel
                    </a>

                </div>

            </div>

        </form>
    </div>

</div>
